<x-app-layout header="Record New Transaction">
    <x-slot:actions>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <x-alert />

            <div class="card p-6">
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf

                    <div class="form-grid form-grid-2">
                        <div class="form-group">
                            <label class="form-label" id="watch_label">Watch *</label>
                            <select name="watch_id" id="watch_id" class="form-select" required onchange="updateWatchInfo()">
                                <option value="">— Select a watch —</option>
                                @foreach($watches as $watch)
                                    <option value="{{ $watch->id }}" data-price="{{ $watch->asking_price }}" {{ old('watch_id')==$watch->id?'selected':'' }}>
                                        {{ $watch->brand }} {{ $watch->model }} (₱{{ number_format($watch->asking_price,2) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('watch_id')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Client *</label>
                            <div class="relative" id="client-search-wrapper">
                                <input type="text" id="client_search" placeholder="Search client name..." class="form-input w-full" autocomplete="off">
                                <input type="hidden" name="client_id" id="client_id" value="{{ old('client_id') }}" required>
                                <div id="client-results" class="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden max-h-48 overflow-y-auto"></div>
                            </div>
                            @error('client_id')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Transaction Type *</label>
                            <select name="type" id="transaction_type" class="form-select" required>
                                <option value="">— Select type —</option>
                                <option value="sale" {{ old('type')=='sale'?'selected':'' }}>Sale</option>
                                <option value="buy" {{ old('type')=='buy'?'selected':'' }}>Buy</option>
                                <option value="trade_in" {{ old('type')=='trade_in'?'selected':'' }}>Trade-in</option>
                            </select>
                            @error('type')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" id="amount_label">Amount (₱) *</label>
                            <input type="number" name="amount" class="form-input" value="{{ old('amount') }}" step="0.01" min="0" required>
                            @error('amount')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div id="trade_in_fields" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 hidden">
                        <div class="form-group md:col-span-2">
                            <label class="form-label">Trade-in Watch</label>
                            <select name="trade_in_watch_id" class="form-select">
                                <option value="">— Select trade-in watch —</option>
                                @foreach($watches as $watch)
                                    <option value="{{ $watch->id }}" {{ old('trade_in_watch_id') == $watch->id ? 'selected' : '' }}>
                                        {{ $watch->brand }} {{ $watch->model }}
                                    </option>
                                @endforeach
                            </select>
                            @error('trade_in_watch_id')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Trade-in Value (₱)</label>
                            <input type="number" name="trade_in_appraisal_value" class="form-input" value="{{ old('trade_in_appraisal_value') }}" step="0.01" min="0">
                            @error('trade_in_appraisal_value')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group md:col-span-3">
                            <label class="form-label">Who adds cash?</label>
                            <select name="trade_in_cash_from" class="form-select">
                                <option value="">— Select who adds cash —</option>
                                <option value="company" {{ old('trade_in_cash_from') === 'company' ? 'selected' : '' }}>Company adds cash</option>
                                <option value="client" {{ old('trade_in_cash_from') === 'client' ? 'selected' : '' }}>Client adds cash</option>
                            </select>
                            @error('trade_in_cash_from')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group mt-6">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-textarea" rows="3">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="btn btn-primary">Record Transaction</button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Summary -->
        <div class="space-y-6">
            <div class="card p-5 sticky" style="top: 100px;">
                <h3 class="text-base font-bold text-gray-900 mb-4">Transaction Summary</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Selected Watch</span>
                        <strong id="summary_watch" class="font-serif text-gray-900">—</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Asking Price</span>
                        <strong id="summary_price" class="text-gray-900">₱0.00</strong>
                    </div>
                    <div class="border-t border-gray-200 my-2"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Entered Amount</span>
                        <strong id="summary_amount" class="text-gray-900">₱0.00</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Difference</span>
                        <strong id="summary_variance" class="text-gray-900">—</strong>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Processed By</span>
                            <strong class="text-gray-900">{{ auth()->user()->name }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Client search functionality
        let clientSearchTimeout;
        const searchInput = document.getElementById('client_search');
        const resultsDiv = document.getElementById('client-results');
        const clientIdInput = document.getElementById('client_id');

        searchInput.addEventListener('input', function() {
            clearTimeout(clientSearchTimeout);
            const query = this.value.trim();
            
            if (query.length < 1) {
                resultsDiv.classList.add('hidden');
                return;
            }

            clientSearchTimeout = setTimeout(() => {
                fetch(`/api/clients/search?query=${encodeURIComponent(query)}`)
                    .then(r => r.json())
                    .then(clients => {
                        resultsDiv.innerHTML = '';
                        if (clients.length === 0) {
                            resultsDiv.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500">No clients found</div>';
                        } else {
                            clients.forEach(client => {
                                const div = document.createElement('div');
                                div.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm border-b border-gray-100';
                                div.innerHTML = `<strong>${client.name}</strong>${client.phone ? `<br><span class="text-xs text-gray-500">${client.phone}</span>` : ''}`;
                                div.onclick = () => {
                                    searchInput.value = client.name;
                                    clientIdInput.value = client.id;
                                    resultsDiv.classList.add('hidden');
                                };
                                resultsDiv.appendChild(div);
                            });
                        }
                        resultsDiv.classList.remove('hidden');
                    });
            }, 300);
        });

        document.addEventListener('click', (e) => {
            if (!document.getElementById('client-search-wrapper')?.contains(e.target)) {
                resultsDiv.classList.add('hidden');
            }
        });

        const transactionType = document.getElementById('transaction_type');
        const tradeInFields = document.getElementById('trade_in_fields');
        const watchLabel = document.getElementById('watch_label');
        const amountLabel = document.getElementById('amount_label');

        function updateTransactionTypeUi() {
            const type = transactionType.value;

            tradeInFields.classList.toggle('hidden', type !== 'trade_in');

            if (type === 'buy') {
                watchLabel.textContent = 'Watch Purchased *';
                amountLabel.textContent = 'Purchase Price (₱) *';
            } else if (type === 'trade_in') {
                watchLabel.textContent = 'Watch Sold *';
                amountLabel.textContent = 'Cash Difference (₱) *';
            } else {
                watchLabel.textContent = 'Watch *';
                amountLabel.textContent = 'Amount (₱) *';
            }
        }

        transactionType.addEventListener('change', updateTransactionTypeUi);

        // Watch info functionality
        function updateWatchInfo() {
            const select = document.getElementById('watch_id');
            const selectedOption = select.options[select.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            const text = selectedOption.text.split('(')[0].trim();

            document.getElementById('summary_watch').textContent = text || '—';
            document.getElementById('summary_price').textContent = price ? `₱${price.toLocaleString('en-PH', {minimumFractionDigits: 2})}` : '₱0.00';
            updateVariance();
        }

        document.querySelector('input[name="amount"]')?.addEventListener('input', updateVariance);

        function updateVariance() {
            const select = document.getElementById('watch_id');
            const selectedOption = select.options[select.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price || 0);
            const amount = parseFloat(document.querySelector('input[name="amount"]').value || 0);

            document.getElementById('summary_amount').textContent = `₱${amount.toLocaleString('en-PH', {minimumFractionDigits: 2})}`;

            if (price && amount) {
                const variance = amount - price;
                const varianceEl = document.getElementById('summary_variance');
                varianceEl.textContent = variance >= 0
                    ? `+₱${variance.toLocaleString('en-PH', {minimumFractionDigits: 2})}`
                    : `-₱${Math.abs(variance).toLocaleString('en-PH', {minimumFractionDigits: 2})}`;
                varianceEl.style.color = variance >= 0 ? '#16a34a' : '#dc2626';
            } else {
                document.getElementById('summary_variance').textContent = '—';
            }
        }

        updateWatchInfo();
        updateTransactionTypeUi();
    </script>
</x-app-layout>
