<x-app-layout header="Client Profile">
    <x-slot:actions>
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back to Clients</a>
    </x-slot:actions>

    <x-alert />

    <div style="display: grid; template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
        <!-- Client Info Card -->
        <div class="card">
            <div style="padding: 0; border-bottom: 1px solid var(--gray-light);">
                <div style="padding: 1.5rem;">
                    <h2 style="margin: 0 0 0.5rem 0; font-size: 1.5rem;">{{ $client->full_name }}</h2>
                    <p style="margin: 0; color: var(--gray-mid); font-size: 0.875rem;">Client ID: #{{ $client->id }}</p>
                </div>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: grid; gap: 1rem; font-size: 0.875rem;">
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Email</span>
                        <p style="margin: 0.25rem 0 0 0;">{{ $client->email ?? '—' }}</p>
                    </div>
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Phone</span>
                        <p style="margin: 0.25rem 0 0 0;">{{ $client->phone }}</p>
                    </div>
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Address</span>
                        <p style="margin: 0.25rem 0 0 0;">{{ $client->address ?? '—' }}</p>
                    </div>
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Joined</span>
                        <p style="margin: 0.25rem 0 0 0;">{{ $client->created_at->format('M d, Y') }}</p>
                    </div>
                    @if($client->notes)
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Notes</span>
                        <p style="margin: 0.25rem 0 0 0; font-size: 0.8125rem;">{{ $client->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div style="display: grid; gap: 1rem;">
            <!-- Total Spent -->
            <div class="card" style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="margin: 0; color: var(--gray-mid); font-size: 0.875rem; font-weight: 500;">Total Spent</p>
                        <h3 style="margin: 0.5rem 0 0 0; font-size: 1.75rem; font-weight: 700;">${{ number_format($totalSpent, 2) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Outstanding Balance -->
            <div class="card" style="padding: 1.5rem; border-left: 4px solid {{ $outstandingBalance > 0 ? '#ff9800' : '#4caf50' }};">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="margin: 0; color: var(--gray-mid); font-size: 0.875rem; font-weight: 500;">Outstanding Balance</p>
                        <h3 style="margin: 0.5rem 0 0 0; font-size: 1.75rem; font-weight: 700; color: {{ $outstandingBalance > 0 ? '#d32f2f' : '#4caf50' }};">
                            {{ $outstandingBalance > 0 ? '—' : '+' }}${{ number_format(abs($outstandingBalance), 2) }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Average Transaction -->
            <div class="card" style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="margin: 0; color: var(--gray-mid); font-size: 0.875rem; font-weight: 500;">Avg. Per Transaction</p>
                        <h3 style="margin: 0.5rem 0 0 0; font-size: 1.75rem; font-weight: 700;">${{ number_format($averageSpend, 2) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Transaction Count -->
            <div class="card" style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="margin: 0; color: var(--gray-mid); font-size: 0.875rem; font-weight: 500;">Transactions</p>
                        <h3 style="margin: 0.5rem 0 0 0; font-size: 1.75rem; font-weight: 700;">{{ $totalTransactions }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card" style="padding: 0;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-light);">
            <h3 style="margin: 0; font-size: 1rem; font-weight: 600;">Recent Transactions</h3>
        </div>
        @if($recentTransactions->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr></thead>
                <tbody>
                @foreach($recentTransactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                    <td><span style="text-transform: capitalize;">{{ $transaction->type }}</span></td>
                    <td>${{ number_format($transaction->total_amount, 2) }}</td>
                    <td><x-status-badge :status="$transaction->status" /></td>
                    <td>
                        <a href="{{ route('transactions.show', $transaction) }}" class="btn-link">View</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="padding: 2rem; text-align: center; color: var(--gray-mid); font-size: 0.875rem;">
            No transactions yet.
        </div>
        @endif
    </div>
</x-app-layout>