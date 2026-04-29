<x-app-layout header="Transactions">
    <x-slot:actions><a href="{{ route('transactions.create') }}" class="btn btn-primary">+ New Transaction</a></x-slot:actions>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_transactions'] }}</div>
            <div class="stat-label">Total Transactions</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">₱{{ number_format($stats['total_sales'], 0) }}</div>
            <div class="stat-label">Sales Revenue</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">₱{{ number_format($stats['total_trades'], 0) }}</div>
            <div class="stat-label">Trade-in Value</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['this_month'] }}</div>
            <div class="stat-label">This Month</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <input type="text" name="search" placeholder="Search by invoice, watch, or client..." value="{{ request('search') }}" class="filter-input">
            </div>
            <div class="filter-group">
                <select name="type" class="filter-select">
                    <option value="">All Types</option>
                    <option value="sale" {{ request('type') === 'sale' ? 'selected' : '' }}>Sale</option>
                    <option value="trade_in" {{ request('type') === 'trade_in' ? 'selected' : '' }}>Trade-in</option>
                </select>
            </div>
            <div class="filter-group">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="filter-input">
            </div>
            <div class="filter-group">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="filter-input">
            </div>
            <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-ghost">Clear</a>
        </form>
    </div>

    @if($transactions->count())
    <div class="card modern-table-wrapper">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Watch Details</th>
                    <th>Client</th>
                    <th>Staff</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                <tr class="table-row">
                    <td class="invoice-cell">
                        <span class="invoice-badge">{{ $t->invoice_number }}</span>
                    </td>
                    <td>
                        <div class="watch-info">
                            <strong>{{ $t->watch->brand }}</strong>
                            <span class="text-muted">{{ $t->watch->model }}</span>
                        </div>
                    </td>
                    <td>{{ $t->client->first_name }} {{ $t->client->last_name }}</td>
                    <td>{{ $t->staff->name }}</td>
                    <td>
                        <span class="badge badge-{{ $t->type }}">
                            {{ ucfirst(str_replace('_', ' ', $t->type)) }}
                        </span>
                    </td>
                    <td class="amount-cell">
                        <strong>₱{{ number_format($t->amount, 2) }}</strong>
                    </td>
                    <td class="date-cell">{{ $t->created_at->format('M d, Y') }}</td>
                    <td class="action-cell">
                        <div class="action-buttons">
                            <a href="{{ route('transactions.show', $t) }}" class="btn btn-sm btn-ghost" title="View">View</a>
                            <a href="{{ route('transactions.edit', $t) }}" class="btn btn-sm btn-ghost" title="Edit">Edit</a>
                            <form method="POST" action="{{ route('transactions.destroy', $t) }}" onsubmit="return confirm('Delete this transaction?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-ghost text-danger" title="Delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="pagination-wrapper">
        {{ $transactions->links() }}
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">No records</div>
        <p class="empty-title">No transactions found</p>
        <p class="empty-text">Start by recording your first transaction</p>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Record Transaction</a>
    </div>
    @endif
</x-app-layout>