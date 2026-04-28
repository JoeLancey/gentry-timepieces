<x-app-layout header="Reports">
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;margin-bottom:2rem;">
        <div class="card" style="background:var(--black);color:var(--white);">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:#666;margin-bottom:0.5rem;">Total Revenue</p>
            <p style="font-family:'Playfair Display',serif;font-size:1.8rem;margin:0;">₱{{ number_format($confirmedPayments, 2) }}</p>
            <p style="font-size:0.7rem;color:#888;margin-top:0.5rem;">From confirmed payments</p>
        </div>
        <div class="card">
            <p class="stat-label">Total Sales</p>
            <p class="stat-value blue">{{ $salesCount }}</p>
            <p style="font-size:0.7rem;color:var(--gray-mid);margin-top:0.5rem;">₱{{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="card">
            <p class="stat-label">Active Consignments</p>
            <p class="stat-value purple">{{ $activeConsignments }}</p>
            <p style="font-size:0.7rem;color:var(--gray-mid);margin-top:0.5rem;">₱{{ number_format($consignmentValue, 2) }}</p>
        </div>
        <div class="card">
            <p class="stat-label">Pending Payments</p>
            <p class="stat-value" style="color:#ea580c;">₱{{ number_format($pendingPayments, 2) }}</p>
            <p style="font-size:0.7rem;color:var(--gray-mid);margin-top:0.5rem;">Awaiting confirmation</p>
        </div>
    </div>

    <!-- Sales Trend Chart -->
    <div class="card" style="margin-bottom:2rem;">
        <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1rem;">Sales Trend (Last 30 Days)</p>
        <div style="background:#fafafa;padding:1rem;border-radius:3px;min-height:280px;">
            @if($salesData->count())
                <canvas id="salesTrendChart" height="120"></canvas>
            @else
                <div style="height:250px;display:flex;align-items:center;justify-content:center;color:var(--gray-mid);">
                    No sales data available
                </div>
            @endif
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
        <!-- Watches by Condition -->
        <div class="card">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1rem;">Inventory by Condition</p>
            @forelse($watchesBycondition as $condition)
                <div style="margin-bottom:1rem;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.3rem;">
                        <span style="font-size:0.8rem;font-weight:bold;">{{ $condition->condition }}</span>
                        <span style="font-size:0.8rem;color:var(--gray-mid);">{{ $condition->count }}</span>
                    </div>
                    <div style="background:var(--gray-pale);height:8px;border-radius:2px;overflow:hidden;">
                        <div style="background:var(--black);height:100%;width:{{ ($condition->count / $watchesBycondition->sum('count') * 100) }}%;"></div>
                    </div>
                    <p style="font-size:0.65rem;color:var(--gray-mid);margin-top:0.25rem;">₱{{ number_format($condition->total_cost, 0) }} cost / ₱{{ number_format($condition->total_asking, 0) }} asking</p>
                </div>
            @empty
                <p style="color:var(--gray-mid);">No inventory data</p>
            @endforelse
        </div>

        <!-- Payment Methods -->
        <div class="card">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1rem;">Payments by Method</p>
            @forelse($paymentsByMethod as $method)
                <div style="margin-bottom:1rem;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.3rem;">
                        <span style="font-size:0.8rem;font-weight:bold;text-transform:capitalize;">{{ str_replace('_', ' ', $method->method) }}</span>
                        <span style="font-size:0.8rem;color:var(--gray-mid);">{{ $method->count }}</span>
                    </div>
                    <div style="background:var(--gray-pale);height:8px;border-radius:2px;overflow:hidden;">
                        <div style="background:#1d4ed8;height:100%;width:{{ ($method->total / $paymentsByMethod->sum('total') * 100) }}%;"></div>
                    </div>
                    <p style="font-size:0.65rem;color:var(--gray-mid);margin-top:0.25rem;">₱{{ number_format($method->total, 0) }}</p>
                </div>
            @empty
                <p style="color:var(--gray-mid);">No payment data</p>
            @endforelse
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
        <!-- Watch Status Distribution -->
        <div class="card">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1rem;">Watches by Status</p>
            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                @forelse($watchesByStatus as $status)
                    <div style="display:flex;align-items:center;gap:1rem;">
                        <span class="badge badge-{{ $status->status }}">{{ $status->status }}</span>
                        <span style="font-weight:bold;font-size:0.9rem;">{{ $status->count }}</span>
                        <div style="flex:1;background:var(--gray-pale);height:6px;border-radius:2px;">
                            <div style="background:var(--black);height:100%;width:{{ ($status->count / $watchesByStatus->sum('count') * 100) }}%;border-radius:2px;"></div>
                        </div>
                    </div>
                @empty
                    <p style="color:var(--gray-mid);">No status data</p>
                @endforelse
            </div>
        </div>

        <!-- Appraisal Stats -->
        <div class="card">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1rem;">Appraisal Progress</p>
            <div style="margin-bottom:1.5rem;">
                <div style="display:flex;justify-content:space-between;margin-bottom:0.3rem;">
                    <span style="font-size:0.9rem;font-weight:bold;">Completed</span>
                    <span style="font-size:0.9rem;color:var(--gray-mid);">{{ $appraisalsCompleted }}</span>
                </div>
                <div style="background:var(--gray-pale);height:10px;border-radius:2px;">
                    <div style="background:#16a34a;height:100%;width:{{ ($appraisalsCompleted / max(1, $appraisalsCompleted + $appraisalsPending) * 100) }}%;border-radius:2px;"></div>
                </div>
            </div>
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:0.3rem;">
                    <span style="font-size:0.9rem;font-weight:bold;">Pending</span>
                    <span style="font-size:0.9rem;color:var(--gray-mid);">{{ $appraisalsPending }}</span>
                </div>
                <div style="background:var(--gray-pale);height:10px;border-radius:2px;">
                    <div style="background:#ea580c;height:100%;width:{{ ($appraisalsPending / max(1, $appraisalsCompleted + $appraisalsPending) * 100) }}%;border-radius:2px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Clients -->
    <div class="card" style="padding:0;">
        <div style="padding:1.5rem;border-bottom:1px solid var(--gray-pale);">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin:0;">Top 10 Clients by Sales</p>
        </div>
        @if($topClients->count())
            <div class="table-wrapper">
                <table class="gt-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Transactions</th>
                            <th>Total Spent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topClients as $client)
                            <tr>
                                <td><strong>{{ $client->client?->name ?? 'Unknown' }}</strong></td>
                                <td>{{ $client->transaction_count }}</td>
                                <td><strong>₱{{ number_format($client->total_spent, 2) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="padding:2rem;text-align:center;color:var(--gray-mid);">No client data available</div>
        @endif
    </div>

    @if($salesData->count())
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const canvas = document.getElementById('salesTrendChart');

                if (!canvas || typeof Chart === 'undefined') {
                    return;
                }

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
                            legend: {
                                display: false,
                            },
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
                                grid: {
                                    display: false,
                                },
                                ticks: {
                                    color: '#6b6b6b',
                                },
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e5e5e5',
                                },
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