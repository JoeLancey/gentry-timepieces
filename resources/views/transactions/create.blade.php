<x-app-layout header="Record New Transaction">
    <x-slot:actions><a href="{{ route('transactions.index') }}" class="btn btn-secondary">← Back</a></x-slot:actions>

    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>Transaction Details</h2>
                <p>Fill in the information below to record a new transaction</p>
            </div>

            <form method="POST" action="{{ route('transactions.store') }}" class="modern-form">
                @csrf

                <!-- Watch Selection -->
                <div class="form-section">
                    <label class="form-label required">Watch</label>
                    <select name="watch_id" id="watch_id" class="form-control" required onchange="updateWatchInfo()">
                        <option value="">— Select a watch —</option>
                        @foreach($watches as $watch)
                            <option value="{{ $watch->id }}" data-price="{{ $watch->asking_price }}" {{ old('watch_id') == $watch->id ? 'selected' : '' }}>
                                {{ $watch->brand }} {{ $watch->model }} (₱{{ number_format($watch->asking_price, 2) }})
                            </option>
                        @endforeach
                    </select>
                    @error('watch_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Grid Layout -->
                <div class="form-grid-2">
                    <!-- Client Selection -->
                    <div class="form-section">
                        <label class="form-label required">Client</label>
                        <select name="client_id" class="form-control" required>
                            <option value="">— Select a client —</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->first_name }} {{ $client->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <!-- Transaction Type -->
                    <div class="form-section">
                        <label class="form-label required">Transaction Type</label>
                        <select name="type" class="form-control" required>
                            <option value="">— Select type —</option>
                            <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>Sale</option>
                            <option value="trade_in" {{ old('type') == 'trade_in' ? 'selected' : '' }}>Trade-in</option>
                        </select>
                        @error('type')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <!-- Amount -->
                    <div class="form-section">
                        <label class="form-label required">Amount (₱)</label>
                        <div class="input-with-hint">
                            <input type="number" name="amount" class="form-control" step="0.01" min="0"
                                value="{{ old('amount') }}" placeholder="0.00" required>
                            <span class="input-hint" id="watch_price_hint"></span>
                        </div>
                        @error('amount')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <!-- Assigned Staff -->
                    <div class="form-section">
                        <label class="form-label required">Assigned Staff</label>
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
                </div>

                <!-- Notes -->
                <div class="form-section">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="4"
                        placeholder="Add any additional notes about this transaction...">{{ old('notes') }}</textarea>
                    @error('notes')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Record Transaction
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>

        <!-- Summary Panel -->
        <div class="form-sidebar">
            <div class="summary-card">
                <h3>Transaction Summary</h3>
                <div class="summary-item">
                    <span>Watch</span>
                    <strong id="summary_watch">—</strong>
                </div>
                <div class="summary-item">
                    <span>Asking Price</span>
                    <strong id="summary_price">—</strong>
                </div>
                <div class="summary-item">
                    <span>Entered Amount</span>
                    <strong id="summary_amount">—</strong>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-item summary-highlight">
                    <span>Variance</span>
                    <strong id="summary_variance">—</strong>
                </div>
            </div>
        </div>
    </div>

    

    <script>
        function updateWatchInfo() {
            const select = document.getElementById('watch_id');
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.dataset.price || 0;
            const text = selectedOption.text.split('(')[0].trim();
            
            document.getElementById('summary_watch').textContent = text || '—';
            document.getElementById('summary_price').textContent = price ? `₱${parseFloat(price).toLocaleString('en-PH', {minimumFractionDigits: 2})}` : '—';
            document.getElementById('watch_price_hint').textContent = price ? `Est. ₱${parseFloat(price).toLocaleString('en-PH', {minimumFractionDigits: 2})}` : '';
            updateVariance();
        }
        
        document.querySelector('input[name="amount"]')?.addEventListener('input', updateVariance);
        
        function updateVariance() {
            const select = document.getElementById('watch_id');
            const selectedOption = select.options[select.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price || 0);
            const amount = parseFloat(document.querySelector('input[name="amount"]').value || 0);
            
            document.getElementById('summary_amount').textContent = amount ? `₱${amount.toLocaleString('en-PH', {minimumFractionDigits: 2})}` : '—';
            
            if (price && amount) {
                const variance = amount - price;
                const varianceEl = document.getElementById('summary_variance');
                varianceEl.textContent = variance >= 0 
                    ? `+₱${variance.toLocaleString('en-PH', {minimumFractionDigits: 2})}`
                    : `-₱${Math.abs(variance).toLocaleString('en-PH', {minimumFractionDigits: 2})}`;
                varianceEl.style.color = variance >= 0 ? '#000' : '#000';
                varianceEl.style.fontWeight = '700';
            } else {
                document.getElementById('summary_variance').textContent = '—';
            }
        }
        
        updateWatchInfo();
    </script>
</x-app-layout>