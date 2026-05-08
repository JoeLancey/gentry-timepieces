<x-app-layout header="New Appraisal">
    <x-slot:actions>
        <a href="{{ route('appraisals.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="max-w-2xl">
        <x-alert />

        <div class="card p-6">
            <form method="POST" action="{{ route('appraisals.store') }}">
                @csrf

                <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <h3 class="text-base font-bold text-gray-900 tracking-tight">Watch Intake</h3>
                    <p class="text-sm text-gray-500 mt-1">Enter the new watch details brought in by the client. The system will create the watch record automatically.</p>
                </div>

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Brand *</label>
                        <input type="text" name="watch_brand" class="form-input" value="{{ old('watch_brand') }}" placeholder="e.g. Rolex" required>
                        @error('watch_brand')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Model *</label>
                        <input type="text" name="watch_model" class="form-input" value="{{ old('watch_model') }}" placeholder="e.g. Submariner" required>
                        @error('watch_model')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Reference Number</label>
                        <input type="text" name="watch_reference_number" class="form-input" value="{{ old('watch_reference_number') }}" placeholder="Optional reference number">
                        @error('watch_reference_number')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Serial Number *</label>
                        <input type="text" name="watch_serial_number" class="form-input" value="{{ old('watch_serial_number') }}" placeholder="Unique serial number" required>
                        @error('watch_serial_number')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Year Produced</label>
                        <input type="number" name="watch_year_produced" class="form-input" value="{{ old('watch_year_produced') }}" min="1800" max="{{ date('Y') }}">
                        @error('watch_year_produced')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Condition *</label>
                        <select name="watch_condition" class="form-select" required>
                            <option value="">Select condition</option>
                            @foreach(['mint','excellent','good','fair'] as $condition)
                                <option value="{{ $condition }}" {{ old('watch_condition')===$condition ? 'selected' : '' }}>{{ ucfirst($condition) }}</option>
                            @endforeach
                        </select>
                        @error('watch_condition')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="flex gap-6 my-6 flex-wrap">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="watch_has_box" value="1" class="gt-checkbox" {{ old('watch_has_box')?'checked':'' }}>
                        <span class="text-sm text-gray-700">Watch Has Box</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="watch_has_papers" value="1" class="gt-checkbox" {{ old('watch_has_papers')?'checked':'' }}>
                        <span class="text-sm text-gray-700">Watch Has Papers</span>
                    </label>
                </div>

                <div class="form-group mb-6">
                    <label class="form-label">Watch Description</label>
                    <textarea name="watch_description" class="form-textarea" placeholder="Brief description of the watch">{{ old('watch_description') }}</textarea>
                    @error('watch_description')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="divider"></div>

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Client</label>
                        <select name="client_id" class="form-select">
                            <option value="">Select Client (Optional)</option>
                            @foreach($clients ?? [] as $client)
                                <option value="{{ $client->id }}" {{ old('client_id')==$client->id?'selected':'' }}>
                                    {{ $client->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Appraiser *</label>
                        <select name="appraiser_id" class="form-select" required>
                            <option value="">Select Appraiser</option>
                            @foreach($appraisers as $appraiser)
                                <option value="{{ $appraiser->id }}" {{ old('appraiser_id')==$appraiser->id?'selected':'' }}>
                                    {{ $appraiser->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('appraiser_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Appraised Value (₱) *</label>
                        <input type="number" name="appraised_value" class="form-input" value="{{ old('appraised_value') }}" step="0.01" min="0" required>
                        @error('appraised_value')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select" required>
                            @foreach(['pending','completed','rejected'] as $s)
                                <option value="{{ $s }}" {{ old('status','pending')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="flex gap-6 mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="has_box" value="1" class="gt-checkbox" {{ old('has_box')?'checked':'' }}>
                        <span class="text-sm text-gray-700">Has Box</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="has_papers" value="1" class="gt-checkbox" {{ old('has_papers')?'checked':'' }}>
                        <span class="text-sm text-gray-700">Has Papers</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">Condition Notes *</label>
                    <textarea name="condition_notes" class="form-textarea" required>{{ old('condition_notes') }}</textarea>
                    @error('condition_notes')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">Save Appraisal</button>
                    <a href="{{ route('appraisals.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>