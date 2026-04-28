<x-app-layout header="Transaction Detail">
    <x-slot name="actions">
        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot>
    <div style="max-width:700px;"><div class="card">
        <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1.25rem;">Transaction Information</p>
        <div class="detail-row"><span class="detail-label">Invoice Number</span><span class="detail-value" style="font-family:'Playfair Display',serif;">{{ $transaction->invoice_number }}</span></div>
        <div class="detail-row"><span class="detail-label">Watch</span><span class="detail-value">{{ $transaction->watch->brand }} {{ $transaction->watch->model }}</span></div>
        <div class="detail-row"><span class="detail-label">Client</span><span class="detail-value">{{ $transaction->client->first_name }} {{ $transaction->client->last_name }}</span></div>
        <div class="detail-row"><span class="detail-label">Staff</span><span class="detail-value">{{ $transaction->staff->name }}</span></div>
        <div class="detail-row"><span class="detail-label">Type</span><span class="detail-value"><span class="badge badge-{{ $transaction->type }}">{{ $transaction->type }}</span></span></div>
        <div class="detail-row"><span class="detail-label">Amount</span><span class="detail-value" style="font-family:'Playfair Display',serif;font-size:1.2rem;">₱{{ number_format($transaction->amount,2) }}</span></div>
        <div class="detail-row"><span class="detail-label">Notes</span><span class="detail-value" style="color:var(--gray-mid);">{{ $transaction->notes ?? '—' }}</span></div>
        <div class="detail-row"><span class="detail-label">Date</span><span class="detail-value">{{ $transaction->created_at->format('F d, Y') }}</span></div>
    </div></div>
</x-app-layout>