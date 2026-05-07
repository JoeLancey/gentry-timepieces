<x-app-layout header="Edit Appraisal">
    <x-slot:actions>
        <a href="{{ route('appraisals.show', $appraisal) }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="max-w-2xl">
        <div class="card p-6">
            <form method="POST" action="{{ route('appraisals.update', $appraisal) }}">
                @csrf @method('PUT')

                <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <h3 class="text-base font-bold text-gray-900 tracking-tight">Watch Intake</h3>
                    <p class="text-sm text-gray-500 mt-1">Update the watch details linked to this appraisal.</p>
                </div>

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Brand *</label>
                        <input type="text" name="watch_brand" class="form-input" value="{{ old('watch_brand', $appraisal->watch->brand) }}" required>
                        @error('watch_brand')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Model *</label>
                        <input type="text" name="watch_model" class="form-input" value="{{ old('watch_model', $appraisal->watch->model) }}" required>
                        @error('watch_model')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Reference Number</label>
                        <input type="text" name="watch_reference_number" class="form-input" value="{{ old('watch_reference_number', $appraisal->watch->reference_number) }}">
                        @error('watch_reference_number')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Serial Number *</label>
                        <input type="text" name="watch_serial_number" class="form-input" value="{{ old('watch_serial_number', $appraisal->watch->serial_number) }}" required>
                        @error('watch_serial_number')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Year Produced</label>
                        <input type="number" name="watch_year_produced" class="form-input" value="{{ old('watch_year_produced', $appraisal->watch->year_produced) }}" min="1800" max="{{ date('Y') }}">
                        @error('watch_year_produced')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Condition *</label>
                        <select name="watch_condition" class="form-select" required>
                            @foreach(['mint','excellent','good','fair'] as $condition)
                                <option value="{{ $condition }}" {{ old('watch_condition', $appraisal->watch->condition)===$condition ? 'selected' : '' }}>{{ ucfirst($condition) }}</option>
                            @endforeach
                        </select>
                        @error('watch_condition')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="flex gap-6 my-6 flex-wrap">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="watch_has_box" value="1" class="gt-checkbox" {{ old('watch_has_box', $appraisal->watch->has_box)?'checked':'' }}>
                        <span class="text-sm text-gray-700">Watch Has Box</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="watch_has_papers" value="1" class="gt-checkbox" {{ old('watch_has_papers', $appraisal->watch->has_papers)?'checked':'' }}>
                        <span class="text-sm text-gray-700">Watch Has Papers</span>
                    </label>
                </div>

                <div class="form-group mb-6">
                    <label class="form-label">Watch Description</label>
                    <textarea name="watch_description" class="form-textarea">{{ old('watch_description', $appraisal->watch->description) }}</textarea>
                    @error('watch_description')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="divider"></div>

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Appraiser *</label>
                        <select name="appraiser_id" class="form-select" required>
                            @foreach($appraisers as $appraiser)
                                <option value="{{ $appraiser->id }}" {{ old('appraiser_id',$appraisal->appraiser_id)==$appraiser->id?'selected':'' }}>
                                    {{ $appraiser->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('appraiser_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Appraised Value (₱) *</label>
                        <input type="number" name="appraised_value" class="form-input" value="{{ old('appraised_value',$appraisal->appraised_value) }}" step="0.01" required>
                        @error('appraised_value')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select" required>
                            @foreach(['pending','completed','rejected'] as $s)
                                <option value="{{ $s }}" {{ old('status',$appraisal->status)==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Condition Notes *</label>
                    <textarea name="condition_notes" class="form-textarea" required>{{ old('condition_notes',$appraisal->condition_notes) }}</textarea>
                    @error('condition_notes')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">Update Appraisal</button>
                    <a href="{{ route('appraisals.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>