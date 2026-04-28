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
            ->when(request('search'), fn($q) => $q->whereHas('client', fn($sq) => $sq->where('first_name', 'like', "%{request('search')}%")))
            ->latest()
            ->paginate(15);
        $expiringSoon = Consignment::expiringSoon()->count();
        return view('consignments.index', compact('consignments', 'expiringSoon')); 
    }
    public function create() { 
        return view('consignments.create', ['watches'=>Watch::available()->get(),'clients'=>Client::all()]); 
    }
    public function store(StoreConsignmentRequest $request) {
        Consignment::create($request->validated());
        return redirect()->route('consignments.index')->with('success','Consignment saved.');
    }
    public function show(Consignment $consignment) { 
        return view('consignments.show', compact('consignment')); 
    }
    public function edit(Consignment $consignment) { 
        return view('consignments.edit', ['consignment'=>$consignment,'watches'=>Watch::all(),'clients'=>Client::all()]); 
    }
    public function update(UpdateConsignmentRequest $request, Consignment $consignment) {
        $consignment->update($request->validated());
        return redirect()->route('consignments.index')->with('success','Consignment updated.');
    }
    public function destroy(Consignment $consignment) { 
        $consignment->delete(); 
        return redirect()->route('consignments.index')->with('success','Consignment deleted.'); 
    }
}