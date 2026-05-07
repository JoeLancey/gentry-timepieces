<x-app-layout header="Edit Transaction">
    <x-slot:actions>
        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="card p-6">
                <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                    @csrf @method('PUT')

                    <div class="form-grid form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Watch *</label>
                            <select name="watch_id" class="form-select" required>
                                @foreach($watches as $watch)
                                    <option value="{{ $watch->id }}" {{ old('watch_id',$transaction->watch_id)==$watch->id?'selected':'' }}>
                                        {{ $watch->brand }} {{ $watch->model }}
                                    </option>
                                @endforeach
                            </select>
                            @error('watch_id')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Client *</label>
                            <div class="relative" id="client-search-wrapper">
                                <input type="text" id="client_search" placeholder="Search client name..." class="form-input w-full" autocomplete="off" value="{{ $transaction->client->full_name ?? '' }}">
                                <input type="hidden" name="client_id" id="client_id" value="{{ old('client_id', $transaction->client_id) }}" required>
                                <div id="client-results" class="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden max-h-48 overflow-y-auto"></div>
                            </div>
                            @error('client_id')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Type *</label>
                            <select name="type" class="form-select" required>
                                <option value="sale" {{ old('type',$transaction->type)=='sale'?'selected':'' }}>Sale</option>
                                <option value="trade_in" {{ old('type',$transaction->type)=='trade_in'?'selected':'' }}>Trade-in</option>
                            </select>
                            @error('type')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Amount (₱) *</label>
                            <input type="number" name="amount" class="form-input" value="{{ old('amount',$transaction->amount) }}" step="0.01" required>
                            @error('amount')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group mt-6">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-textarea">{{ old('notes',$transaction->notes) }}</textarea>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="btn btn-primary">Update Transaction</button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card p-5">
                <h3 class="text-base font-bold text-gray-900 mb-4">Transaction Info</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Invoice</span>
                        <strong class="font-mono">{{ $transaction->invoice_number }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Type</span>
                        <strong class="capitalize">{{ str_replace('_',' ',$transaction->type) }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Created</span>
                        <strong>{{ $transaction->created_at->format('M d, Y') }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Processed By</span>
                        <strong>{{ $transaction->staff->name }}</strong>
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
    </script>
</x-app-layout>
