<?php
namespace App\Http\Controllers;
use App\Models\Consignment;
use App\Models\Watch;
use App\Models\Client;
use App\Http\Requests\StoreConsignmentRequest;
use App\Http\Requests\UpdateConsignmentRequest;
use Illuminate\Support\Facades\DB;

class ConsignmentController extends Controller {
    public function index() { 
        $consignments = Consignment::with(['watch','client'])
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->when(request('search'), function ($q) {
                $search = request('search');

                $q->where(function ($subQuery) use ($search) {
                    $subQuery->whereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery
                            ->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    })->orWhereHas('watch', function ($watchQuery) use ($search) {
                        $watchQuery
                            ->where('brand', 'like', "%{$search}%")
                            ->orWhere('model', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(15);
        $expiringSoon = Consignment::expiringSoon()->count();
        return view('consignments.index', compact('consignments', 'expiringSoon')); 
    }
    public function create() { 
        return view('consignments.create'); 
    }
    public function store(StoreConsignmentRequest $request) {
        DB::transaction(function () use ($request) {
            // Create the watch with consigned status
            $watch = Watch::create([
                'brand' => $request->watch_brand,
                'model' => $request->watch_model,
                'reference_number' => $request->watch_reference_number,
                'serial_number' => $request->watch_serial_number,
                'year_produced' => $request->watch_year_produced,
                'condition' => $request->watch_condition,
                'has_box' => $request->boolean('watch_has_box'),
                'has_papers' => $request->boolean('watch_has_papers'),
                'asking_price' => $request->agreed_price,
                'cost_price' => 0,
                'status' => 'consigned',
                'description' => $request->watch_description,
            ]);

            // Create the consignment with the new watch
            Consignment::create([
                'watch_id' => $watch->id,
                'client_id' => $request->client_id,
                'agreed_price' => $request->agreed_price,
                'commission_rate' => $request->commission_rate,
                'status' => 'active',
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'notes' => $request->notes,
            ]);
        });
        return redirect()->route('consignments.index')->with('success','Consignment saved.');
    }
    public function show(Consignment $consignment) { 
        return view('consignments.show', compact('consignment')); 
    }
    public function edit(Consignment $consignment) { 
        return view('consignments.edit', ['consignment'=>$consignment,'watches'=>Watch::all()]); 
    }
    public function update(UpdateConsignmentRequest $request, Consignment $consignment) {
        $originalWatchId = $consignment->watch_id;
        $consignment->update($request->validated());
        $this->syncWatchStatus($consignment);
        if ($originalWatchId !== $consignment->watch_id) {
            Watch::whereKey($originalWatchId)->update(['status' => 'available']);
        }
        return redirect()->route('consignments.index')->with('success','Consignment updated.');
    }
    public function destroy(Consignment $consignment) { 
        if ($consignment->watch) {
            $consignment->watch->update(['status' => 'available']);
        }
        $consignment->delete(); 
        return redirect()->route('consignments.index')->with('success','Consignment deleted.'); 
    }

    private function syncWatchStatus(Consignment $consignment): void
    {
        $watchStatus = match ($consignment->status) {
            'active' => 'consigned',
            'sold' => 'sold',
            'returned', 'expired' => 'available',
            default => 'available',
        };

        if ($consignment->watch) {
            $updateData = ['status' => $watchStatus];
            
            // When sold from consignment, set cost_price to agreed_price for inventory tracking
            if ($consignment->status === 'sold') {
                $updateData['cost_price'] = $consignment->agreed_price;
            }
            
            $consignment->watch->update($updateData);
        }
    }
}