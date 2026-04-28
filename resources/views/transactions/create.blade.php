<x-app-layout header="New Transaction">
    <x-slot:actions><a href="{{ route('transactions.index') }}" class="btn btn-secondary">← Back</a></x-slot:actions>

    <div class="card" style="max-width: 720px;">
        <form method="POST" action="{{ route('transactions.store') }}">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">

                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Watch <span style="color:#d32f2f;">*</span></label>
                    <select name="watch_id" class="form-control" required>
                        <option value="">— Select a watch —</option>
                        @foreach($watches as $watch)
                            <option value="{{ $watch->id }}" {{ old('watch_id') == $watch->id ? 'selected' : '' }}>
                                {{ $watch->brand }} {{ $watch->model }} — ₱{{ number_format($watch->asking_price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('watch_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Client <span style="color:#d32f2f;">*</span></label>
                    <select name="client_id" class="form-control" required>
                        <option value="">— Select a client —</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Type <span style="color:#d32f2f;">*</span></label>
                    <select name="type" class="form-control" required>
                        <option value="">— Select type —</option>
                        <option value="sale"     {{ old('type') == 'sale'     ? 'selected' : '' }}>Sale</option>
                        <option value="trade_in" {{ old('type') == 'trade_in' ? 'selected' : '' }}>Trade-in</option>
                    </select>
                    @error('type')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Amount (₱) <span style="color:#d32f2f;">*</span></label>
                    <input type="number" name="amount" class="form-control" step="0.01" min="0"
                        value="{{ old('amount') }}" placeholder="0.00" required>
                    @error('amount')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Assigned Staff <span style="color:#d32f2f;">*</span></label>
                    <select name="staff_id" class="form-control" required>
                        <option value="">— Select staff —</option>
                        @foreach($staff as $user)
                            <option value="{{ $user->id }}" {{ old('staff_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('staff_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3"
                        placeholder="Optional notes about this transaction...">{{ old('notes') }}</textarea>
                    @error('notes')<p class="form-error">{{ $message }}</p>@enderror
                </div>

            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Record Transaction</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>