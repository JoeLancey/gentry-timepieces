<x-app-layout header="Payment Detail">
    <x-slot name="actions">
        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot>
    <div style="max-width:700px;"><div class="card">
        <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1.25rem;">Payment Information</p>
        <div class="detail-row"><span class="detail-label">Transaction</span><span class="detail-value" style="font-family:'Playfair Display',serif;">{{ $payment->transaction->invoice_number }}</span></div>
        <div class="detail-row"><span class="detail-label">Amount</span><span class="detail-value" style="font-family:'Playfair Display',serif;font-size:1.2rem;">₱{{ number_format($payment->amount,2) }}</span></div>
        <div class="detail-row"><span class="detail-label">Method</span><span class="detail-value"><span class="badge badge-{{ $payment->method }}">{{ str_replace('_',' ',$payment->method) }}</span></span></div>
        <div class="detail-row"><span class="detail-label">Reference Number</span><span class="detail-value">{{ $payment->reference_number ?? '—' }}</span></div>
        <div class="detail-row"><span class="detail-label">Status</span><span class="detail-value"><span class="badge badge-{{ $payment->status }}">{{ $payment->status }}</span></span></div>
        <div class="detail-row"><span class="detail-label">Confirmed At</span><span class="detail-value">{{ $payment->confirmed_at ? $payment->confirmed_at->format('F d, Y h:i A') : '—' }}</span></div>
    </div></div>
</x-app-layout> 