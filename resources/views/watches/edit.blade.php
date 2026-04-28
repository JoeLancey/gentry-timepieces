<x-app-layout header="Edit Watch">
    <x-slot:actions><a href="{{ route('watches.show', $watch) }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    <div class="card" style="max-width:860px;">
        <form method="POST" action="{{ route('watches.update', $watch) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-grid form-grid-2">
                <div class="form-group"><label class="gt-label">Brand *</label><input type="text" name="brand" class="gt-input" value="{{ old('brand',$watch->brand) }}" required></div>
                <div class="form-group"><label class="gt-label">Model *</label><input type="text" name="model" class="gt-input" value="{{ old('model',$watch->model) }}" required></div>
                <div class="form-group"><label class="gt-label">Serial Number *</label><input type="text" name="serial_number" class="gt-input" value="{{ old('serial_number',$watch->serial_number) }}" required></div>
                <div class="form-group"><label class="gt-label">Reference Number</label><input type="text" name="reference_number" class="gt-input" value="{{ old('reference_number',$watch->reference_number) }}"></div>
                <div class="form-group"><label class="gt-label">Year Produced</label><input type="number" name="year_produced" class="gt-input" value="{{ old('year_produced',$watch->year_produced) }}"></div>
                <div class="form-group"><label class="gt-label">Condition *</label>
                    <select name="condition" class="gt-select" required>@foreach(['mint','excellent','good','fair'] as $c)<option value="{{ $c }}" {{ old('condition',$watch->condition)==$c?'selected':'' }}>{{ ucfirst($c) }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">Asking Price (₱) *</label><input type="number" name="asking_price" class="gt-input" value="{{ old('asking_price',$watch->asking_price) }}" step="0.01" required></div>
                <div class="form-group"><label class="gt-label">Cost Price (₱) *</label><input type="number" name="cost_price" class="gt-input" value="{{ old('cost_price',$watch->cost_price) }}" step="0.01" required></div>
                <div class="form-group"><label class="gt-label">Status *</label>
                    <select name="status" class="gt-select" required>@foreach(['available','sold','consigned','reserved'] as $s)<option value="{{ $s }}" {{ old('status',$watch->status)==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">New Image</label><input type="file" name="image" class="gt-input" accept="image/*"></div>
            </div>
            <div class="divider"></div>
            <div style="display:flex;gap:2rem;margin-bottom:1.25rem;">
                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;cursor:pointer;"><input type="checkbox" name="has_box" value="1" class="gt-checkbox" {{ old('has_box',$watch->has_box)?'checked':'' }}> Includes Box</label>
                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;cursor:pointer;"><input type="checkbox" name="has_papers" value="1" class="gt-checkbox" {{ old('has_papers',$watch->has_papers)?'checked':'' }}> Includes Papers</label>
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;"><label class="gt-label">Description</label><textarea name="description" class="gt-textarea">{{ old('description',$watch->description) }}</textarea></div>
            <div style="display:flex;gap:0.75rem;"><button type="submit" class="btn btn-primary">Update Watch</button><a href="{{ route('watches.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-app-layout>