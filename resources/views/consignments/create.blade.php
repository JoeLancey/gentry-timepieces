<x-app-layout header="New Consignment">
    <x-slot:actions><a href="{{ route('consignments.index') }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    <div class="card" style="max-width:700px;">
        <form method="POST" action="{{ route('consignments.store') }}">
            @csrf
            <div class="form-grid form-grid-2">
                <div class="form-group"><label class="gt-label">Watch *</label>
                    <select name="watch_id" class="gt-select" required><option value="">Select Watch</option>@foreach($watches as $w)<option value="{{ $w->id }}" {{ old('watch_id')==$w->id?'selected':'' }}>{{ $w->brand }} {{ $w->model }} — {{ $w->serial_number }}</option>@endforeach</select>
                    @error('watch_id')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Client *</label>
                    <select name="client_id" class="gt-select" required><option value="">Select Client</option>@foreach($clients as $c)<option value="{{ $c->id }}" {{ old('client_id')==$c->id?'selected':'' }}>{{ $c->first_name }} {{ $c->last_name }}</option>@endforeach</select>
                    @error('client_id')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Agreed Price (₱) *</label><input type="number" name="agreed_price" class="gt-input" value="{{ old('agreed_price') }}" step="0.01" min="0" required>@error('agreed_price')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Commission Rate (%) *</label><input type="number" name="commission_rate" class="gt-input" value="{{ old('commission_rate') }}" step="0.01" min="0" max="100" required>@error('commission_rate')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Status *</label>
                    <select name="status" class="gt-select" required>@foreach(['active','sold','returned','expired'] as $s)<option value="{{ $s }}" {{ old('status','active')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">Start Date *</label><input type="date" name="start_date" class="gt-input" value="{{ old('start_date', date('Y-m-d')) }}" required></div>
                <div class="form-group"><label class="gt-label">End Date</label><input type="date" name="end_date" class="gt-input" value="{{ old('end_date') }}"></div>
            </div>
            <div class="form-group" style="margin-top:1.25rem;margin-bottom:1.5rem;"><label class="gt-label">Notes</label><textarea name="notes" class="gt-textarea">{{ old('notes') }}</textarea></div>
            <div style="display:flex;gap:0.75rem;"><button type="submit" class="btn btn-primary">Save Consignment</button><a href="{{ route('consignments.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-app-layout>