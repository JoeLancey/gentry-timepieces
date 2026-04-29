<x-app-layout header="Add Watch">
    <x-slot:actions>
        <a href="{{ route('watches.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="max-w-3xl">
        <x-alert />

        <div class="card p-6">
            <form method="POST" action="{{ route('watches.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Brand *</label>
                        <input type="text" name="brand" class="form-input" value="{{ old('brand') }}" required>
                        @error('brand')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Model *</label>
                        <input type="text" name="model" class="form-input" value="{{ old('model') }}" required>
                        @error('model')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Serial Number *</label>
                        <input type="text" name="serial_number" class="form-input" value="{{ old('serial_number') }}" required>
                        @error('serial_number')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Reference Number</label>
                        <input type="text" name="reference_number" class="form-input" value="{{ old('reference_number') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Year Produced</label>
                        <input type="number" name="year_produced" class="form-input" value="{{ old('year_produced') }}" min="1900" max="{{ date('Y') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Condition *</label>
                        <select name="condition" class="form-select" required>
                            <option value="">Select</option>
                            @foreach(['mint','excellent','good','fair'] as $c)
                                <option value="{{ $c }}" {{ old('condition')==$c?'selected':'' }}>{{ ucfirst($c) }}</option>
                            @endforeach
                        </select>
                        @error('condition')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Asking Price (₱) *</label>
                        <input type="number" name="asking_price" class="form-input" value="{{ old('asking_price') }}" step="0.01" min="0" required>
                        @error('asking_price')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Cost Price (₱) *</label>
                        <input type="number" name="cost_price" class="form-input" value="{{ old('cost_price') }}" step="0.01" min="0" required>
                        @error('cost_price')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select" required>
                            @foreach(['available','sold','consigned','reserved'] as $s)
                                <option value="{{ $s }}" {{ old('status','available')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Watch Image</label>
                        <input type="file" name="image" class="form-input" accept="image/*">
                    </div>
                </div>

                <div class="divider"></div>

                <div class="flex gap-6 mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="has_box" value="1" class="gt-checkbox" {{ old('has_box')?'checked':'' }}>
                        <span class="text-sm text-gray-700">Includes Box</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="has_papers" value="1" class="gt-checkbox" {{ old('has_papers')?'checked':'' }}>
                        <span class="text-sm text-gray-700">Includes Papers</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea">{{ old('description') }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">Save Watch</button>
                    <a href="{{ route('watches.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>