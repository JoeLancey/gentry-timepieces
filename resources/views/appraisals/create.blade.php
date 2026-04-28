<x-app-layout header="New Appraisal">
    <x-slot:actions><a href="{{ route('appraisals.index') }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    <div class="card" style="max-width:700px;">
        <form method="POST" action="{{ route('appraisals.store') }}">
            @csrf
            <div class="form-grid form-grid-2">
                <div class="form-group"><label class="gt-label">Watch *</label>
                    <select name="watch_id" class="gt-select" required><option value="">Select Watch</option>@foreach($watches as $w)<option value="{{ $w->id }}" {{ old('watch_id')==$w->id?'selected':'' }}>{{ $w->brand }} {{ $w->model }} — {{ $w->serial_number }}</option>@endforeach</select>
                    @error('watch_id')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Client *</label>
                    <select name="client_id" class="gt-select" required><option value="">Select Client</option>@foreach($clients as $c)<option value="{{ $c->id }}" {{ old('client_id')==$c->id?'selected':'' }}>{{ $c->first_name }} {{ $c->last_name }}</option>@endforeach</select>
                    @error('client_id')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Appraiser *</label>
                    <select name="appraiser_id" class="gt-select" required><option value="">Select Appraiser</option>@foreach($users as $u)<option value="{{ $u->id }}" {{ old('appraiser_id')==$u->id?'selected':'' }}>{{ $u->name }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">Appraised Value (₱) *</label><input type="number" name="appraised_value" class="gt-input" value="{{ old('appraised_value') }}" step="0.01" min="0" required>@error('appraised_value')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Status *</label>
                    <select name="status" class="gt-select" required>@foreach(['pending','completed','rejected'] as $s)<option value="{{ $s }}" {{ old('status','pending')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
            </div>
            <div class="divider"></div>
            <div style="display:flex;gap:2rem;margin-bottom:1.25rem;">
                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;cursor:pointer;"><input type="checkbox" name="has_box" value="1" class="gt-checkbox" {{ old('has_box')?'checked':'' }}> Has Box</label>
                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;cursor:pointer;"><input type="checkbox" name="has_papers" value="1" class="gt-checkbox" {{ old('has_papers')?'checked':'' }}> Has Papers</label>
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;"><label class="gt-label">Condition Notes *</label><textarea name="condition_notes" class="gt-textarea" required>{{ old('condition_notes') }}</textarea>@error('condition_notes')<span class="form-error">{{ $message }}</span>@enderror</div>
            <div style="display:flex;gap:0.75rem;"><button type="submit" class="btn btn-primary">Save Appraisal</button><a href="{{ route('appraisals.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-app-layout>