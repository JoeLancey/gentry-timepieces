<x-app-layout header="Reports">
    <!-- Key Metrics Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stagger-children">
        <div class="stat-card bg-gray-900 text-white border-0">
            <p class="stat-label" style="color: #9ca3af;">Total Revenue</p>
            <p class="stat-value" style="color: #fff;">₱{{ number_format($confirmedPayments, 2) }}</p>
            <p class="text-xs text-gray-400 mt-2">From confirmed payments</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Total Sales</p>
            <p class="stat-value text-blue-600">{{ $salesCount }}</p>
            <p class="text-sm text-gray-500 mt-2">₱{{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Active Consignments</p>
            <p class="stat-value text-purple-600">{{ $activeConsignments }}</p>
            <p class="text-sm text-gray-500 mt-2">₱{{ number_format($consignmentValue, 2) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Pending Payments</p>
            <p class="stat-value text-orange-600">₱{{ number_format($pendingPayments, 2) }}</p>
            <p class="text-sm text-gray-500 mt-2">Awaiting confirmation</p>
        </div>
    </div>

    <!-- Sales Trend Chart -->
    <div class="card mb-8">
        <div class="card-header">
            <div>
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Sales Trend (Last 30 Days)</h3>
                <p class="text-sm text-gray-500 mt-0.5">Daily revenue overview</p>
            </div>
        </div>
        <div class="p-6" style="min-height: 320px;">
            @if($salesData->count())
                <canvas id="salesTrendChart" height="120"></canvas>
            @else
                <div class="flex items-center justify-center h-64 text-gray-400">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                        </svg>
                        <p>No sales data available</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Watches by Condition -->
        <div class="card p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4 tracking-tight">Inventory by Condition</h3>
            @forelse($watchesBycondition as $condition)
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800 capitalize">{{ $condition->condition }}</span>
                        <span class="text-sm text-gray-500">{{ $condition->count }} watches</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        @php $percentage = ($condition->count / max(1, $watchesBycondition->sum('count')) * 100); @endphp
                        <div class="h-full bg-gray-900 transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        ₱{{ number_format($condition->total_cost, 0) }} cost / ₱{{ number_format($condition->total_asking, 0) }} asking
                    </p>
                </div>
            @empty
                <p class="text-gray-400">No inventory data</p>
            @endforelse
        </div>

        <!-- Payment Methods -->
        <div class="card p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4 tracking-tight">Payments by Method</h3>
            @forelse($paymentsByMethod as $method)
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800 capitalize">{{ str_replace('_', ' ', $method->method) }}</span>
                        <span class="text-sm text-gray-500">{{ $method->count }} payments</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        @php $percentage = ($method->total / max(1, $paymentsByMethod->sum('total')) * 100); @endphp
                        <div class="h-full bg-blue-600 transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">₱{{ number_format($method->total, 0) }}</p>
                </div>
            @empty
                <p class="text-gray-400">No payment data</p>
            @endforelse
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Watch Status Distribution -->
        <div class="card p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4 tracking-tight">Watches by Status</h3>
            <div class="space-y-3">
                @forelse($watchesByStatus as $status)
                    <div class="flex items-center gap-3">
                        <span class="badge badge-{{ $status->status }}">{{ $status->status }}</span>
                        <span class="font-semibold text-gray-800 w-16">{{ $status->count }}</span>
                        <div class="flex-1 bg-gray-200 rounded-full h-2 overflow-hidden">
                            @php $percentage = ($status->count / max(1, $watchesByStatus->sum('count')) * 100); @endphp
                            <div class="h-full bg-gray-900 transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400">No status data</p>
                @endforelse
            </div>
        </div>

        <!-- Appraisal Progress -->
        <div class="card p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4 tracking-tight">Appraisal Progress</h3>
            <div class="space-y-5">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800">Completed</span>
                        <span class="text-sm text-gray-500">{{ $appraisalsCompleted }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        @php $total = max(1, $appraisalsCompleted + $appraisalsPending); @endphp
                        <div class="h-full bg-green-500 transition-all duration-500" style="width: {{ ($appraisalsCompleted / $total) * 100 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800">Pending</span>
                        <span class="text-sm text-gray-500">{{ $appraisalsPending }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div class="h-full bg-orange-500 transition-all duration-500" style="width: {{ ($appraisalsPending / $total) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Clients -->
    <div class="card overflow-hidden p-0">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 tracking-tight">Top 10 Clients by Sales</h3>
        </div>
        @if($topClients->count())
            <div class="table-container border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th class="text-center">Transactions</th>
                            <th class="text-right">Total Spent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topClients as $client)
                            <tr class="group hover:bg-gray-50 transition-colors">
                                <td class="font-semibold text-gray-900">
                                    {{ $client->client?->name ?? 'Unknown' }}
                                </td>
                                <td class="text-center text-gray-600">{{ $client->transaction_count }}</td>
                                <td class="text-right font-bold text-gray-900">
                                    ₱{{ number_format($client->total_spent, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <p class="text-gray-400">No client data available</p>
            </div>
        @endif
    </div>

    @if($salesData->count())
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const canvas = document.getElementById('salesTrendChart');
                if (!canvas || typeof Chart === 'undefined') return;

                const labels = @json($salesData->map(fn ($sale) => $sale->date->format('M d')));
                const totals = @json($salesData->map(fn ($sale) => (float) $sale->total));

                new Chart(canvas, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Daily Sales',
                            data: totals,
                            backgroundColor: '#0a0a0a',
                            borderRadius: 6,
                            borderSkipped: false,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label(context) {
                                        return ' ₱' + Number(context.parsed.y).toLocaleString('en-PH', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        });
                                    },
                                },
                            },
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: '#6b6b6b' },
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: '#e5e5e5' },
                                ticks: {
                                    color: '#6b6b6b',
                                    callback(value) {
                                        return '₱' + Number(value).toLocaleString('en-PH');
                                    },
                                },
                            },
                        },
                    },
                });
            });
        </script>
    @endif
</x-app-layout>