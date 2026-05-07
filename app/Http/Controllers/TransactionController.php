<?php
namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Watch;
use App\Models\Client;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Support\Str;

class TransactionController extends Controller {
    public function index() { 
        $query = Transaction::with(['watch','client','staff']);
        
        // Apply filters
        if(request('type')) $query->where('type', request('type'));
        if(request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('watch', fn($q) => $q->where('brand', 'like', "%{$search}%"))
                  ->orWhereHas('client', fn($q) => $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"));
            });
        }
        if(request('date_from')) $query->whereDate('created_at', '>=', request('date_from'));
        if(request('date_to')) $query->whereDate('created_at', '<=', request('date_to'));
        
        $transactions = $query->latest()->paginate(20);
        
        // Calculate statistics
        $stats = [
            'total_transactions' => Transaction::count(),
            'total_sales' => Transaction::where('type', 'sale')->sum('amount'),
            'total_trades' => Transaction::where('type', 'trade_in')->sum('amount'),
            'this_month' => Transaction::whereMonth('created_at', now()->month)->count(),
        ];
        
        return view('transactions.index', compact('transactions', 'stats')); 
    }
    public function create() { 
        return view('transactions.create', ['watches'=>Watch::all(),'clients'=>Client::all()]); 
    }
    public function store(StoreTransactionRequest $request) {
        $data = $request->validated();
        $data['staff_id'] = auth()->id();
        $data['invoice_number'] = 'INV-' . strtoupper(Str::random(8));
        $transaction = Transaction::create($data);
        $this->syncWatchStatus($transaction);
        return redirect()->route('transactions.index')->with('success','Transaction recorded.');
    }
    public function show(Transaction $transaction) { 
        $transaction->load(['watch', 'tradeInWatch', 'client', 'staff']);
        return view('transactions.show', compact('transaction')); 
    }
    public function edit(Transaction $transaction) { 
        return view('transactions.edit', ['transaction'=>$transaction,'watches'=>Watch::all(),'clients'=>Client::all()]); 
    }
    public function update(UpdateTransactionRequest $request, Transaction $transaction) {
        $originalWatchId = $transaction->watch_id;
        $data = $request->validated();
        $data['staff_id'] = $transaction->staff_id;
        $transaction->update($data);
        $this->syncWatchStatus($transaction);
        if ($originalWatchId !== $transaction->watch_id) {
            Watch::whereKey($originalWatchId)->update(['status' => 'available']);
        }
        return redirect()->route('transactions.index')->with('success','Transaction updated.');
    }
    public function destroy(Transaction $transaction) { 
        if ($transaction->watch) {
            $transaction->watch->update(['status' => 'available']);
        }
        $transaction->delete(); 
        return redirect()->route('transactions.index')->with('success','Transaction deleted.'); 
    }

    private function syncWatchStatus(Transaction $transaction): void
    {
        if ($transaction->type === 'sale') {
            if ($transaction->watch) {
                $transaction->watch->update(['status' => 'sold']);
            }
            return;
        }

        if ($transaction->type === 'buy') {
            if ($transaction->watch) {
                $transaction->watch->update([
                    'status' => 'available',
                    'cost_price' => $transaction->amount,
                ]);
            }
            return;
        }

        if ($transaction->watch) {
            $transaction->watch->update(['status' => 'sold']);
        }

        if ($transaction->tradeInWatch) {
            $transaction->tradeInWatch->update([
                'status' => 'available',
                'cost_price' => $transaction->trade_in_appraisal_value ?? $transaction->amount,
            ]);
        }
    }
}