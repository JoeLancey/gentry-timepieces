<?php
namespace App\Http\Controllers;
use App\Models\Consignment;
use App\Models\Watch;
use App\Models\Client;
use App\Http\Requests\StoreConsignmentRequest;
use App\Http\Requests\UpdateConsignmentRequest;

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
        return view('consignments.create', ['availableWatches'=>Watch::available()->get(),'clients'=>Client::all()]); 
    }
    public function store(StoreConsignmentRequest $request) {
        $consignment = Consignment::create($request->validated());
        $this->syncWatchStatus($consignment);
        return redirect()->route('consignments.index')->with('success','Consignment saved.');
    }
    public function show(Consignment $consignment) { 
        return view('consignments.show', compact('consignment')); 
    }
    public function edit(Consignment $consignment) { 
        return view('consignments.edit', ['consignment'=>$consignment,'watches'=>Watch::all(),'clients'=>Client::all()]); 
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
            $consignment->watch->update(['status' => $watchStatus]);
        }
    }
}