<x-app-layout header="Dashboard">
    <x-slot:actions>
        <a href="{{ route('watches.create') }}" class="btn btn-primary">+ Add Watch</a>
    </x-slot:actions>

    <!-- Error Alert -->
    @if(isset($db_error))
        <div class="alert alert-warning">
            <strong>Database Error:</strong> {{ $db_error }}
        </div>
    @endif

    <!-- Main Stats Grid -->
    <div class="grid grid-cols-4 mb-8">
        <div class="stat-card">
            <div class="stat-label">Total Watches</div>
            <div class="stat-value">{{ $totalWatches }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Available</div>
            <div class="stat-value" style="color: #000;">{{ $availableWatches }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Clients</div>
            <div class="stat-value">{{ $totalClients }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Consignments</div>
            <div class="stat-value" style="color: #000;">{{ $activeConsignments }}</div>
        </div>
    </div>

    <!-- Transaction Stats Grid -->
    <div class="grid grid-cols-4 mb-8">
        <div class="stat-card">
            <div class="stat-label">Total Transactions</div>
            <div class="stat-value">{{ $totalTransactions }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Sales Revenue</div>
            <div class="stat-value" style="color: #000; font-size: 1.6rem;">₱{{ number_format($totalSales, 0) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Trade-in Value</div>
            <div class="stat-value" style="color: #000; font-size: 1.6rem;">₱{{ number_format($totalTradeIns, 0) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value" style="color: #000; font-size: 1.6rem;">₱{{ number_format($totalRevenue, 0) }}</div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        
        <!-- Recent Transactions -->
        <div class="card modern-table-wrapper">
            <div style="padding: 1.5rem; border-bottom: 1px solid #cccccc;">
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; font-weight: 700; letter-spacing: -0.02em;">Recent Transactions</h3>
                <p style="margin: 0; color: #808080; font-size: 0.85rem;">Latest {{ $recentTransactions->count() }} transactions</p>
            </div>
            @if($recentTransactions->count())
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Watch</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $t)
                        <tr>
                            <td class="invoice-cell">
                                <span class="invoice-badge">{{ $t->invoice_number }}</span>
                            </td>
                            <td>{{ $t->watch->brand }} {{ $t->watch->model }}</td>
                            <td>
                                <span class="badge badge-{{ $t->type }}">
                                    {{ ucfirst(str_replace('_', ' ', $t->type)) }}
                                </span>
                            </td>
                            <td class="amount-cell">₱{{ number_format($t->amount, 2) }}</td>
                            <td class="date-cell">{{ $t->created_at->format('M d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding: 2rem; text-align: center; color: #808080;">
                    No transactions recorded yet
                </div>
            @endif
            <div style="padding: 1rem; border-top: 1px solid #cccccc; text-align: right;">
                <a href="{{ route('transactions.index') }}" style="color: #000; text-decoration: none; font-weight: 700; font-size: 0.9rem;">View All Transactions →</a>
            </div>
        </div>

        <!-- Quick Info & Actions -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Quick Actions Card -->
            <div class="card">
                <h3 style="margin: 0 0 1rem 0; font-size: 1rem; font-weight: 700; letter-spacing: -0.02em;">Quick Actions</h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary" style="justify-content: center; width: 100%; padding: 0.75rem;">
                        New Transaction
                    </a>
                    <a href="{{ route('watches.create') }}" class="btn btn-secondary" style="justify-content: center; width: 100%; padding: 0.75rem;">
                        Add Watch
                    </a>
                    <a href="{{ route('clients.create') }}" class="btn btn-secondary" style="justify-content: center; width: 100%; padding: 0.75rem;">
                        New Client
                    </a>
                </div>
            </div>

            <!-- System Info Card -->
            <div class="card" style="background: #000; color: #fff; border: 1px solid #000;">
                <h3 style="margin: 0 0 1rem 0; font-size: 1rem; font-weight: 700; letter-spacing: -0.02em;">System Info</h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                    <div>
                        <span style="opacity: 0.7; display: block; font-size: 0.75rem; margin-bottom: 0.2rem;">Signed In</span>
                        <strong>{{ auth()->user()->name }}</strong>
                    </div>
                    <div>
                        <span style="opacity: 0.7; display: block; font-size: 0.75rem; margin-bottom: 0.2rem;">Role</span>
                        <strong style="text-transform: capitalize;">{{ auth()->user()->role }}</strong>
                    </div>
                    <div>
                        <span style="opacity: 0.7; display: block; font-size: 0.75rem; margin-bottom: 0.2rem;">Date</span>
                        <strong>{{ now()->format('F d, Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section - Appraisals and Consignments -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        
        <!-- Pending Appraisals -->
        <div class="card">
            <h3 style="margin: 0 0 1.25rem 0; font-size: 1.1rem; font-weight: 700; letter-spacing: -0.02em;">Appraisals</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div style="padding: 1rem; background: #f5f5f5; border: 1px solid #eeeeee; border-left: 3px solid #000;">
                    <p style="margin: 0; color: #808080; font-size: 0.85rem;">Pending</p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 1.8rem; font-weight: 700; color: #000;">{{ $pendingAppraisals }}</p>
                </div>
                <div style="padding: 1rem; background: #f5f5f5; border: 1px solid #eeeeee; border-left: 3px solid #000;">
                    <p style="margin: 0; color: #808080; font-size: 0.85rem;">Completed</p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 1.8rem; font-weight: 700; color: #000;">{{ $completedAppraisals }}</p>
                </div>
            </div>
            <a href="{{ route('appraisals.index') }}" style="display: inline-block; margin-top: 1rem; color: #000; text-decoration: none; font-weight: 700; font-size: 0.9rem;">
                View Appraisals →
            </a>
        </div>

        <!-- Consignment Summary -->
        <div class="card">
            <h3 style="margin: 0 0 1.25rem 0; font-size: 1.1rem; font-weight: 700; letter-spacing: -0.02em;">Consignments</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div style="padding: 1rem; background: #f5f5f5; border: 1px solid #eeeeee; border-left: 3px solid #000;">
                    <p style="margin: 0; color: #808080; font-size: 0.85rem;">Active</p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 1.8rem; font-weight: 700; color: #000;">{{ $activeConsignments }}</p>
                </div>
                <div style="padding: 1rem; background: #f5f5f5; border: 1px solid #eeeeee; border-left: 3px solid #000;">
                    <p style="margin: 0; color: #808080; font-size: 0.85rem;">Total Value</p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 1.3rem; font-weight: 700; color: #000;">₱{{ number_format($totalConsignmentValue, 0) }}</p>
                </div>
            </div>
            <a href="{{ route('consignments.index') }}" style="display: inline-block; margin-top: 1rem; color: #000; text-decoration: none; font-weight: 700; font-size: 0.9rem;">
                View Consignments →
            </a>
        </div>
    </div>

</x-app-layout>