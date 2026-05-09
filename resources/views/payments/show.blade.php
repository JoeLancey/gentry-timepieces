<x-app-layout header="Payment Details">
    <x-slot name="actions">
        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot>

    <div class="max-w-2xl">
        <div class="card p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Transaction</p>
                    <p class="font-serif text-lg font-semibold text-gray-900">{{ $payment->transaction->invoice_number }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Amount</p>
                    <p class="text-2xl font-bold text-gray-900">₱{{ number_format($payment->amount, 2) }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Payment Method</p>
                    <p><span class="badge badge-{{ $payment->method }}">{{ ucfirst(str_replace('_',' ',$payment->method)) }}</span></p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Status</p>
                    <p><span class="badge badge-{{ $payment->status }}">{{ ucfirst($payment->status) }}</span></p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Reference Number</p>
                    <p class="font-mono text-gray-900">{{ $payment->reference_number ?? '—' }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Confirmed At</p>
                    <p class="text-gray-900">{{ $payment->confirmed_at ? $payment->confirmed_at->format('M d, Y') : 'Pending' }}</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 flex items-center gap-3">
                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-primary">Edit Payment</a>
                <form method="POST" action="{{ route('payments.destroy', $payment) }}" onsubmit="return confirm('Delete this payment?');" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
