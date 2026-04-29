<x-app-layout header="Client Profile">
    <x-slot:actions>
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">← Back to Clients</a>
    </x-slot:actions>

    <x-alert />

    <!-- Client Info & Key Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Client Info Card -->
        <div class="lg:col-span-2 card p-0 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $client->full_name }}</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Client ID: #{{ $client->id }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="detail-box">
                        <span class="detail-label">Email</span>
                        <span class="detail-value">{{ $client->email ?? '—' }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Phone</span>
                        <span class="detail-value">{{ $client->phone }}</span>
                    </div>
                    <div class="detail-box md:col-span-2">
                        <span class="detail-label">Address</span>
                        <span class="detail-value">{{ $client->address ?? '—' }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Joined</span>
                        <span class="detail-value">{{ $client->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($client->notes)
                    <div class="detail-box md:col-span-2">
                        <span class="detail-label">Notes</span>
                        <span class="detail-value text-gray-600">{{ $client->notes }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Metrics -->
        <div class="space-y-4">
            <div class="stat-card">
                <p class="stat-label">Total Spent</p>
                <p class="stat-value">${{ number_format($totalSpent, 2) }}</p>
            </div>
            <div class="card p-5" style="border-left: 4px solid {{ $outstandingBalance > 0 ? '#dc2626' : '#16a34a' }};">
                <p class="text-sm text-gray-500 mb-2">Outstanding Balance</p>
                <p class="text-2xl font-bold" style="color: {{ $outstandingBalance > 0 ? '#dc2626' : '#16a34a' }};">
                    {{ $outstandingBalance > 0 ? '–' : '+' }}${{ number_format(abs($outstandingBalance), 2) }}
                </p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Average Per Transaction</p>
                <p class="stat-value" style="font-size: 1.75rem;">${{ number_format($averageSpend, 2) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Transactions</p>
                <p class="stat-value">{{ $totalTransactions }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card overflow-hidden p-0">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 tracking-tight">Recent Transactions</h3>
        </div>
        @if($recentTransactions->count())
            <div class="table-container border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="text-gray-500 text-sm">{{ $transaction->created_at->format('M d, Y') }}</td>
                            <td class="capitalize text-gray-700">{{ str_replace('_', ' ', $transaction->type) }}</td>
                            <td class="font-semibold text-gray-900">
                                ${{ number_format($transaction->total_amount, 2) }}
                            </td>
                            <td><x-status-badge :status="$transaction->status" /></td>
                            <td class="text-right">
                                <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-ghost text-sm">
                                    View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <p class="text-gray-500">No transactions yet.</p>
            </div>
        @endif
    </div>
</x-app-layout>