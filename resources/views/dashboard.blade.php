<x-app-layout header="Dashboard">
    <x-slot:actions>
        <a href="{{ route('watches.create') }}" class="btn btn-primary">+ Add Watch</a>
    </x-slot:actions>

    <!-- Database Error Alert -->
    @if(isset($db_error))
        <div class="alert alert-warning mb-6" role="alert">
            <strong class="font-semibold">Database Error:</strong> {{ $db_error }}
        </div>
    @endif

    <!-- Key Metrics Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stagger-children">
        <div class="stat-card group">
            <p class="stat-label">Total Watches</p>
            <p class="stat-value">{{ $totalWatches }}</p>
        </div>
        <div class="stat-card group">
            <p class="stat-label">Available</p>
            <p class="stat-value text-gray-900">{{ $availableWatches }}</p>
        </div>
        <div class="stat-card group">
            <p class="stat-label">Total Clients</p>
            <p class="stat-value">{{ $totalClients }}</p>
        </div>
        <div class="stat-card group">
            <p class="stat-label">Active Consignments</p>
            <p class="stat-value text-gray-900">{{ $activeConsignments }}</p>
        </div>
    </div>

    <!-- Financial Metrics Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stagger-children">
        <div class="stat-card group">
            <p class="stat-label">Total Transactions</p>
            <p class="stat-value text-2xl">{{ $totalTransactions }}</p>
        </div>
        <div class="stat-card group">
            <p class="stat-label">Sales Revenue</p>
            <p class="stat-value text-2xl">₱{{ number_format($totalSales, 0) }}</p>
        </div>
        <div class="stat-card group">
            <p class="stat-label">Trade-in Value</p>
            <p class="stat-value text-2xl">₱{{ number_format($totalTradeIns, 0) }}</p>
        </div>
        <div class="stat-card group">
            <p class="stat-label">Total Revenue</p>
            <p class="stat-value text-2xl">₱{{ number_format($totalRevenue, 0) }}</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Recent Transactions -->
        <div class="lg:col-span-2 card overflow-hidden">
            <div class="card-header bg-gray-50 border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 tracking-tight">Recent Transactions</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Latest {{ $recentTransactions->count() }} transactions</p>
                    </div>
                </div>
            </div>
            @if($recentTransactions->count())
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Watch</th>
                                <th>Type</th>
                                <th class="text-right">Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $t)
                            <tr class="group">
                                <td class="invoice-cell">
                                    <span class="invoice-badge">{{ $t->invoice_number }}</span>
                                </td>
                                <td>
                                    <div class="watch-info">
                                        <strong>{{ $t->watch->brand }} {{ $t->watch->model }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $t->type }}">
                                        {{ ucfirst(str_replace('_', ' ', $t->type)) }}
                                    </span>
                                </td>
                                <td class="text-right font-semibold">
                                    ₱{{ number_format($t->amount, 2) }}
                                </td>
                                <td class="text-gray-500 text-sm">
                                    {{ $t->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <p class="text-gray-500 mb-4">No transactions recorded yet</p>
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary">Create First Transaction</a>
                </div>
            @endif
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-right">
                <a href="{{ route('transactions.index') }}" class="text-sm font-semibold text-gray-900 hover:text-gray-600 transition-colors">
                    View All Transactions →
                </a>
            </div>
        </div>

        <!-- Quick Actions & System Info -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="card p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 tracking-tight">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary w-full py-3 justify-center">
                        New Transaction
                    </a>
                    <a href="{{ route('watches.create') }}" class="btn btn-secondary w-full justify-center">
                        Add Watch
                    </a>
                    <a href="{{ route('clients.create') }}" class="btn btn-secondary w-full justify-center">
                        New Client
                    </a>
                </div>
            </div>

            <!-- System Info -->
            <div class="relative overflow-hidden rounded-xl border border-slate-800 bg-slate-950 text-white p-6 shadow-lg">
                <div class="pointer-events-none absolute -top-12 -right-10 h-36 w-36 rounded-full bg-slate-700/20 blur-2xl"></div>
                <div class="relative">
                    <div class="flex items-start justify-between gap-3 mb-5">
                        <div>
                            <h3 class="text-lg font-semibold tracking-tight">System Info</h3>
                            <p class="text-xs text-slate-400 mt-1 uppercase tracking-[0.16em]">Session Overview</p>
                        </div>
                        <span class="inline-flex items-center rounded-full border border-emerald-400/35 bg-emerald-400/10 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wider text-emerald-300">
                            Online
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 px-4 py-3">
                            <p class="text-[11px] uppercase tracking-[0.16em] text-slate-400">Signed In</p>
                            <p class="mt-1 text-lg font-semibold leading-tight text-white">{{ auth()->user()->name }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-lg border border-slate-800 bg-slate-900/70 px-4 py-3">
                                <p class="text-[11px] uppercase tracking-[0.16em] text-slate-400">Role</p>
                                <p class="mt-1 text-base font-semibold capitalize text-white">{{ auth()->user()->role }}</p>
                            </div>
                            <div class="rounded-lg border border-slate-800 bg-slate-900/70 px-4 py-3">
                                <p class="text-[11px] uppercase tracking-[0.16em] text-slate-400">Date</p>
                                <p class="mt-1 text-base font-semibold text-white">{{ now()->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Appraisals Card -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Appraisals</h3>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-sm text-gray-500 mb-1">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingAppraisals }}</p>
                </div>
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-sm text-gray-500 mb-1">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $completedAppraisals }}</p>
                </div>
            </div>
            <a href="{{ route('appraisals.index') }}" class="inline-block mt-4 text-sm font-semibold text-gray-900 hover:text-gray-600 transition-colors">
                View Appraisals →
            </a>
        </div>

        <!-- Consignments Card -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Consignments</h3>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-sm text-gray-500 mb-1">Active</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeConsignments }}</p>
                </div>
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-sm text-gray-500 mb-1">Total Value</p>
                    <p class="text-2xl font-bold text-gray-900">₱{{ number_format($totalConsignmentValue, 0) }}</p>
                </div>
            </div>
            <a href="{{ route('consignments.index') }}" class="inline-block mt-4 text-sm font-semibold text-gray-900 hover:text-gray-600 transition-colors">
                View Consignments →
            </a>
        </div>
    </div>
</x-app-layout>