<?php
namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Transaction;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller {
    public function index() { 
        $payments = Payment::with('transaction.client')
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->when(request('method'), fn($q) => $q->where('method', request('method')))
            ->latest()
            ->paginate(15);
        return view('payments.index', compact('payments')); 
    }

    public function create() { 
        return view('payments.create', [
            'transactions' => Transaction::with('client')->latest()->get()
        ]); 
    }

    public function store(StorePaymentRequest $request) {
        $data = $request->validated();
        if ($request->hasFile('proof_path')) {
            $data['proof_path'] = $request->file('proof_path')->store('payments','public');
        }
        $data['confirmed_at'] = $data['status'] === 'confirmed' ? now() : null;
        Payment::create($data);
        return redirect()->route('payments.index')->with('success','Payment recorded.');
    }

    public function show(Payment $payment) { 
        return view('payments.show', compact('payment')); 
    }

    public function edit(Payment $payment) { 
        return view('payments.edit', [
            'payment'      => $payment,
            'transactions' => Transaction::with('client')->get()
        ]); 
    }

    public function update(UpdatePaymentRequest $request, Payment $payment) {
        $data = $request->validated();
        if ($request->hasFile('proof_path')) {
            if ($payment->proof_path) Storage::disk('public')->delete($payment->proof_path);
            $data['proof_path'] = $request->file('proof_path')->store('payments','public');
        }
        $data['confirmed_at'] = $data['status'] === 'confirmed' ? ($payment->confirmed_at ?? now()) : null;
        $payment->update($data);
        return redirect()->route('payments.index')->with('success','Payment updated.');
    }

    public function destroy(Payment $payment) { 
        if ($payment->proof_path) Storage::disk('public')->delete($payment->proof_path);
        $payment->delete(); 
        return redirect()->route('payments.index')->with('success','Payment deleted.'); 
    }
}