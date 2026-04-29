<x-app-layout header="New Consignment">
    <x-slot:actions>
        <a href="{{ route('consignments.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="max-w-2xl">
        <x-alert />

        <div class="card p-6">
            <form method="POST" action="{{ route('consignments.store') }}">
                @csrf

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Watch *</label>
                        <select name="watch_id" class="form-select" required>
                            <option value="">Select Watch</option>
                            @foreach($availableWatches as $watch)
                                <option value="{{ $watch->id }}" {{ old('watch_id')==$watch->id?'selected':'' }}>
                                    {{ $watch->brand }} {{ $watch->model }} ({{ $watch->serial_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('watch_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Client *</label>
                        <select name="client_id" class="form-select" required>
                            <option value="">Select Client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id')==$client->id?'selected':'' }}>
                                    {{ $client->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Agreed Price (₱) *</label>
                        <input type="number" name="agreed_price" class="form-input" value="{{ old('agreed_price') }}" step="0.01" min="0" required>
                        @error('agreed_price')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Commission Rate (%) *</label>
                        <input type="number" name="commission_rate" class="form-input" value="{{ old('commission_rate',10) }}" min="0" max="100" required>
                        @error('commission_rate')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Start Date *</label>
                        <input type="date" name="start_date" class="form-input" value="{{ old('start_date',date('Y-m-d')) }}" required>
                        @error('start_date')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-input" value="{{ old('end_date') }}">
                        @error('end_date')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select" required>
                            @foreach(['active','sold','returned','expired'] as $s)
                                <option value="{{ $s }}" {{ old('status','active')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group mt-6">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-textarea">{{ old('notes') }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">Save Consignment</button>
                    <a href="{{ route('consignments.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>