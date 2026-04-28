<?php
namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Watch;
use App\Models\Client;
use App\Models\User;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Support\Str;

class TransactionController extends Controller {
    public function index() { 
        $transactions = Transaction::with(['watch','client','staff'])
            ->when(request('type'), fn($q) => $q->where('type', request('type')))
            ->when(request('search'), fn($q) => $q->where('invoice_number', 'like', "%{request('search')}%"))
            ->latest()
            ->paginate(15);
        return view('transactions.index', compact('transactions')); 
    }
    public function create() { 
        return view('transactions.create', ['watches'=>Watch::available()->get(),'clients'=>Client::all(),'staff'=>User::where('role','staff')->get()]); 
    }
    public function store(StoreTransactionRequest $request) {
        $data = $request->validated();
        $data['staff_id'] = auth()->id();
        $data['invoice_number'] = 'INV-' . strtoupper(Str::random(8));
        $transaction = Transaction::create($data);
        Watch::find($request->watch_id)->update(['status'=>'sold']);
        return redirect()->route('transactions.index')->with('success','Transaction recorded.');
    }
    public function show(Transaction $transaction) { 
        return view('transactions.show', compact('transaction')); 
    }
    public function edit(Transaction $transaction) { 
        return view('transactions.edit', ['transaction'=>$transaction,'watches'=>Watch::all(),'clients'=>Client::all(),'staff'=>User::where('role','staff')->get()]); 
    }
    public function update(UpdateTransactionRequest $request, Transaction $transaction) {
        $transaction->update($request->validated());
        return redirect()->route('transactions.index')->with('success','Transaction updated.');
    }
    public function destroy(Transaction $transaction) { 
        $transaction->delete(); 
        return redirect()->route('transactions.index')->with('success','Transaction deleted.'); 
    }
}