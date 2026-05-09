<x-app-layout header="Client Profile">
    <x-slot name="actions">
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">← Back to Clients</a>
    </x-slot>

    <x-alert />

    <div class="card p-6 mb-8">
        <div class="mb-6 p-4 rounded-lg border border-gray-200 bg-gray-50">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Client Status</p>
            <div class="flex items-center gap-3 flex-wrap">
                <span class="badge badge-active">Active</span>
                <span class="text-sm text-gray-600">Client ID #{{ $client->id }} · Joined {{ $client->created_at->format('M d, Y') }}</span>
            </div>
        </div>

        <div class="mb-6 p-4 rounded-lg border border-gray-200 bg-white">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Client Timeline</p>
            <div class="space-y-4">
                @forelse($timeline->sortBy('created_at')->values() as $entry)
                    <div class="flex items-start gap-3">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-gray-900"></span>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $entry->action)) }}</p>
                            <p class="text-sm text-gray-600">{{ $entry->description }}</p>
                            <p class="text-xs text-gray-500">{{ $entry->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No client activity yet.</p>
                @endforelse
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Client</p>
                <p class="font-semibold text-gray-900">{{ $client->full_name }}</p>
                <p class="text-sm text-gray-500">{{ $client->email ?? 'No email on file' }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Phone</p>
                <p class="font-semibold text-gray-900">{{ $client->phone }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Total Spent</p>
                <p class="text-2xl font-bold text-gray-900">₱{{ number_format($totalSpent, 2) }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Outstanding Balance</p>
                <p class="text-2xl font-bold {{ $outstandingBalance > 0 ? 'text-red-600' : 'text-green-600' }}">
                    {{ $outstandingBalance > 0 ? '₱' : '₱' }}{{ number_format(abs($outstandingBalance), 2) }}
                </p>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Average Transaction</p>
                <p class="text-2xl font-bold text-gray-900">₱{{ number_format($averageSpend, 2) }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Transactions</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalTransactions }}</p>
            </div>

            <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Address</p>
                <p class="text-gray-900">{{ $client->address ?? 'No address provided' }}</p>
            </div>

            @if($client->notes)
            <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Notes</p>
                <p class="text-gray-700">{{ $client->notes }}</p>
            </div>
            @endif
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200 flex items-center gap-3 flex-wrap">
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary">Edit Client</a>
            <a href="{{ route('transactions.create', ['client_id' => $client->id]) }}" class="btn btn-secondary">New Transaction</a>
            <a href="{{ route('appraisals.create', ['client_id' => $client->id]) }}" class="btn btn-secondary">New Appraisal</a>
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
                                ₱{{ number_format($transaction->amount, 2) }}
                            </td>
                            <td>
                                <span class="badge {{ $transaction->is_fully_paid ? 'badge-completed' : 'badge-pending' }}">
                                    {{ $transaction->payment_status }}
                                </span>
                            </td>
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