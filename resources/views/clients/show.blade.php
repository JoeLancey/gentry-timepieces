<x-app-layout header="Client Detail">
    <x-slot:actions>
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>
    <div style="max-width:700px;">
        <div class="card">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1.25rem;">Client Information</p>
            <div class="detail-row"><span class="detail-label">Full Name</span><span class="detail-value">{{ $client->first_name }} {{ $client->last_name }}</span></div>
            <div class="detail-row"><span class="detail-label">Phone</span><span class="detail-value">{{ $client->phone }}</span></div>
            <div class="detail-row"><span class="detail-label">Email</span><span class="detail-value">{{ $client->email ?? '—' }}</span></div>
            <div class="detail-row"><span class="detail-label">Address</span><span class="detail-value">{{ $client->address ?? '—' }}</span></div>
            <div class="detail-row"><span class="detail-label">Notes</span><span class="detail-value" style="color:var(--gray-mid);">{{ $client->notes ?? '—' }}</span></div>
            <div class="detail-row"><span class="detail-label">Registered</span><span class="detail-value">{{ $client->created_at->format('F d, Y') }}</span></div>
        </div>
    </div>
</x-app-layout>