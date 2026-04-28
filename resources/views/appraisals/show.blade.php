<x-app-layout header="Appraisal Detail">
    <x-slot name="actions">
        <a href="{{ route('appraisals.edit', $appraisal) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('appraisals.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot>
    <div style="max-width:700px;">
        <div class="card">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1.25rem;">Appraisal Information</p>
            <div class="detail-row"><span class="detail-label">Watch</span><span class="detail-value">{{ $appraisal->watch->brand }} {{ $appraisal->watch->model }}</span></div>
            <div class="detail-row"><span class="detail-label">Serial Number</span><span class="detail-value">{{ $appraisal->watch->serial_number }}</span></div>
            <div class="detail-row"><span class="detail-label">Client</span><span class="detail-value">{{ $appraisal->client->first_name }} {{ $appraisal->client->last_name }}</span></div>
            <div class="detail-row"><span class="detail-label">Appraiser</span><span class="detail-value">{{ $appraisal->appraiser->name }}</span></div>
            <div class="detail-row"><span class="detail-label">Appraised Value</span><span class="detail-value" style="font-family:'Playfair Display',serif;font-size:1.2rem;">₱{{ number_format($appraisal->appraised_value,2) }}</span></div>
            <div class="detail-row"><span class="detail-label">Status</span><span class="detail-value"><span class="badge badge-{{ $appraisal->status }}">{{ $appraisal->status }}</span></span></div>
            <div class="detail-row"><span class="detail-label">Has Box</span><span class="detail-value">{{ $appraisal->has_box ? 'Yes' : 'No' }}</span></div>
            <div class="detail-row"><span class="detail-label">Has Papers</span><span class="detail-value">{{ $appraisal->has_papers ? 'Yes' : 'No' }}</span></div>
            <div class="detail-row"><span class="detail-label">Condition Notes</span><span class="detail-value" style="color:var(--gray-mid);">{{ $appraisal->condition_notes }}</span></div>
            <div class="detail-row"><span class="detail-label">Date</span><span class="detail-value">{{ $appraisal->created_at->format('F d, Y') }}</span></div>
        </div>
    </div>
</x-app-layout>