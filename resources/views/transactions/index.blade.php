<x-app-layout header="Transactions">
    <x-slot:actions>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">+ Add Transaction</a>
    </x-slot:actions>

    <x-alert />

    <div class="card p-5 mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900 tracking-tight">Record a transaction</h2>
            <p class="text-sm text-gray-500 mt-1">Create a sale or trade-in record for a watch and client.</p>
        </div>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary justify-center">
            + Add Transaction
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stagger-children">
        <div class="stat-card">
            <p class="stat-label">Total Transactions</p>
            <p class="stat-value">{{ $stats['total_transactions'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Sales Revenue</p>
            <p class="stat-value text-2xl">₱{{ number_format($stats['total_sales'], 0) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Trade-in Value</p>
            <p class="stat-value text-2xl">₱{{ number_format($stats['total_trades'], 0) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">This Month</p>
            <p class="stat-value">{{ $stats['this_month'] }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <label class="form-label">Search</label>
                <input type="text" name="search" placeholder="Search by invoice, watch, or client..."
                       value="{{ request('search') }}" class="form-input">
            </div>

            <div class="filter-group">
                <label class="form-label">Transaction Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="sale" {{ request('type') === 'sale' ? 'selected' : '' }}>Sale</option>
                    <option value="buy" {{ request('type') === 'buy' ? 'selected' : '' }}>Buy</option>
                    <option value="trade_in" {{ request('type') === 'trade_in' ? 'selected' : '' }}>Trade-in</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="form-label">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input">
            </div>

            <div class="filter-group">
                <label class="form-label">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary" title="Clear filters">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
        </form>
    </div>

    @if($transactions->count())
        <div class="card overflow-hidden p-0">
            <div class="table-container border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Watch Details</th>
                            <th>Client</th>
                            <th>Staff</th>
                            <th>Type</th>
                            <th class="text-right">Amount</th>
                            <th>Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $t)
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td>
                                <span class="invoice-badge">{{ $t->invoice_number }}</span>
                            </td>
                            <td>
                                <div class="watch-info">
                                    <strong>{{ $t->watch->brand }}</strong>
                                    <span class="text-gray-500">{{ $t->watch->model }}</span>
                                </div>
                            </td>
                            <td class="text-gray-700">{{ $t->client->first_name }} {{ $t->client->last_name }}</td>
                            <td class="text-gray-600">{{ $t->staff->name }}</td>
                            <td>
                                <span class="badge badge-{{ $t->type }}">
                                    {{ ucfirst(str_replace('_', ' ', $t->type)) }}
                                </span>
                            </td>
                            <td class="text-right font-semibold text-gray-900">
                                ₱{{ number_format($t->amount, 2) }}
                            </td>
                            <td class="text-gray-500 text-sm">{{ $t->created_at->format('M d, Y') }}</td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('transactions.show', $t) }}" class="btn btn-ghost text-sm" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('transactions.edit', $t) }}" class="btn btn-ghost text-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('transactions.destroy', $t) }}" onsubmit="return confirm('Delete this transaction?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-ghost text-danger text-sm" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $transactions->links() }}
            </div>
        </div>
    @else
        <div class="card">
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <h4 class="empty-title">No transactions found</h4>
                <p class="empty-text">Start recording your sales and trade-ins.</p>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary">+ Add Transaction</a>
            </div>
        </div>
    @endif
</x-app-layout>