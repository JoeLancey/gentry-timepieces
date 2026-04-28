<x-app-layout header="Consignment Detail">
    <x-slot name="actions">
        <a href="{{ route('consignments.edit', $consignment) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('consignments.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot>
    <div style="max-width:700px;"><div class="card">
        <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1.25rem;">Consignment Information</p>
        <div class="detail-row"><span class="detail-label">Watch</span><span class="detail-value">{{ $consignment->watch->brand }} {{ $consignment->watch->model }}</span></div>
        <div class="detail-row"><span class="detail-label">Serial Number</span><span class="detail-value">{{ $consignment->watch->serial_number }}</span></div>
        <div class="detail-row"><span class="detail-label">Client</span><span class="detail-value">{{ $consignment->client->first_name }} {{ $consignment->client->last_name }}</span></div>
        <div class="detail-row"><span class="detail-label">Agreed Price</span><span class="detail-value" style="font-family:'Playfair Display',serif;font-size:1.2rem;">₱{{ number_format($consignment->agreed_price,2) }}</span></div>
        <div class="detail-row"><span class="detail-label">Commission Rate</span><span class="detail-value">{{ $consignment->commission_rate }}%</span></div>
        <div class="detail-row"><span class="detail-label">Status</span><span class="detail-value"><span class="badge badge-{{ $consignment->status }}">{{ $consignment->status }}</span></span></div>
        <div class="detail-row"><span class="detail-label">Start Date</span><span class="detail-value">{{ $consignment->start_date->format('F d, Y') }}</span></div>
        <div class="detail-row"><span class="detail-label">End Date</span><span class="detail-value">{{ $consignment->end_date ? $consignment->end_date->format('F d, Y') : '—' }}</span></div>
        <div class="detail-row"><span class="detail-label">Notes</span><span class="detail-value" style="color:var(--gray-mid);">{{ $consignment->notes ?? '—' }}</span></div>
    </div></div>
</x-app-layout>