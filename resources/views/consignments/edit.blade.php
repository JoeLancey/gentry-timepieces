<x-app-layout header="Edit Consignment">
    <x-slot:actions><a href="{{ route('consignments.show', $consignment) }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    <div class="card" style="max-width:700px;">
        <form method="POST" action="{{ route('consignments.update', $consignment) }}">
            @csrf @method('PUT')
            <div class="form-grid form-grid-2">
                <div class="form-group"><label class="gt-label">Watch *</label>
                    <select name="watch_id" class="gt-select" required><option value="">Select Watch</option>@foreach($watches as $w)<option value="{{ $w->id }}" {{ old('watch_id',$consignment->watch_id)==$w->id?'selected':'' }}>{{ $w->brand }} {{ $w->model }} — {{ $w->serial_number }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">Client *</label>
                    <select name="client_id" class="gt-select" required><option value="">Select Client</option>@foreach($clients as $c)<option value="{{ $c->id }}" {{ old('client_id',$consignment->client_id)==$c->id?'selected':'' }}>{{ $c->first_name }} {{ $c->last_name }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">Agreed Price (₱) *</label><input type="number" name="agreed_price" class="gt-input" value="{{ old('agreed_price',$consignment->agreed_price) }}" step="0.01" required></div>
                <div class="form-group"><label class="gt-label">Commission Rate (%) *</label><input type="number" name="commission_rate" class="gt-input" value="{{ old('commission_rate',$consignment->commission_rate) }}" step="0.01" required></div>
                <div class="form-group"><label class="gt-label">Status *</label>
                    <select name="status" class="gt-select" required>@foreach(['active','sold','returned','expired'] as $s)<option value="{{ $s }}" {{ old('status',$consignment->status)==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">Start Date *</label><input type="date" name="start_date" class="gt-input" value="{{ old('start_date',$consignment->start_date->format('Y-m-d')) }}" required></div>
                <div class="form-group"><label class="gt-label">End Date</label><input type="date" name="end_date" class="gt-input" value="{{ old('end_date',$consignment->end_date?->format('Y-m-d')) }}"></div>
            </div>
            <div class="form-group" style="margin-top:1.25rem;margin-bottom:1.5rem;"><label class="gt-label">Notes</label><textarea name="notes" class="gt-textarea">{{ old('notes',$consignment->notes) }}</textarea></div>
            <div style="display:flex;gap:0.75rem;"><button type="submit" class="btn btn-primary">Update Consignment</button><a href="{{ route('consignments.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-app-layout>