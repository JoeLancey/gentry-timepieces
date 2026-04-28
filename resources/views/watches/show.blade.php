<x-app-layout header="Watch Detail">
    <x-slot:actions>
        <a href="{{ route('watches.edit', $watch) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('watches.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;max-width:1000px;">
        <div class="card">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1.25rem;">Watch Information</p>
            <div class="detail-row"><span class="detail-label">Brand</span><span class="detail-value">{{ $watch->brand }}</span></div>
            <div class="detail-row"><span class="detail-label">Model</span><span class="detail-value">{{ $watch->model }}</span></div>
            <div class="detail-row"><span class="detail-label">Serial Number</span><span class="detail-value">{{ $watch->serial_number }}</span></div>
            <div class="detail-row"><span class="detail-label">Reference Number</span><span class="detail-value">{{ $watch->reference_number ?? '—' }}</span></div>
            <div class="detail-row"><span class="detail-label">Year Produced</span><span class="detail-value">{{ $watch->year_produced ?? '—' }}</span></div>
            <div class="detail-row"><span class="detail-label">Condition</span><span class="detail-value"><span class="badge badge-{{ $watch->condition }}">{{ $watch->condition }}</span></span></div>
            <div class="detail-row"><span class="detail-label">Status</span><span class="detail-value"><span class="badge badge-{{ $watch->status }}">{{ $watch->status }}</span></span></div>
            <div class="detail-row"><span class="detail-label">Has Box</span><span class="detail-value">{{ $watch->has_box ? 'Yes' : 'No' }}</span></div>
            <div class="detail-row"><span class="detail-label">Has Papers</span><span class="detail-value">{{ $watch->has_papers ? 'Yes' : 'No' }}</span></div>
            @if($watch->description)<div class="detail-row"><span class="detail-label">Description</span><span class="detail-value" style="color:var(--gray-mid);">{{ $watch->description }}</span></div>@endif
        </div>
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="card" style="background:var(--black);color:var(--white);">
                <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:#444;margin-bottom:1.25rem;">Pricing</p>
                <div style="margin-bottom:1rem;"><p style="font-size:0.6rem;letter-spacing:0.15em;text-transform:uppercase;color:#444;margin-bottom:0.25rem;">Asking Price</p><p style="font-family:'Playfair Display',serif;font-size:2rem;color:#fff;">₱{{ number_format($watch->asking_price,2) }}</p></div>
                @if(auth()->user()->isAdmin())<div><p style="font-size:0.6rem;letter-spacing:0.15em;text-transform:uppercase;color:#444;margin-bottom:0.25rem;">Cost Price</p><p style="font-family:'Playfair Display',serif;font-size:1.4rem;color:#888;">₱{{ number_format($watch->cost_price,2) }}</p></div>@endif
            </div>
            @if($watch->image_path)
            <div class="card" style="padding:0;overflow:hidden;">
                <img src="{{ Storage::url($watch->image_path) }}" alt="{{ $watch->brand }}" style="width:100%;height:250px;object-fit:cover;">
            </div>
            @endif
        </div>
    </div>
</x-app-layout>