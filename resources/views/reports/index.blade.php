<x-app-layout header="Reports">
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-bottom:2rem;">
        <div class="card" style="background:var(--black);color:var(--white);">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:#444;margin-bottom:1rem;">Total Revenue</p>
            <p style="font-family:'Playfair Display',serif;font-size:2rem;">₱{{ number_format($totalRevenue,2) }}</p>
        </div>
        <div class="card">
            <p class="stat-label">Watches Sold</p>
            <p class="stat-value blue">{{ $watchesSold }}</p>
        </div>
        <div class="card">
            <p class="stat-label">Active Consignments</p>
            <p class="stat-value purple">{{ $activeConsignments }}</p>
        </div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
        <div class="card" style="padding:0;">
            <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--gray-pale);"><p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);">Recent Transactions</p></div>
            <table class="gt-table">
                <thead><tr><th>Invoice</th><th>Client</th><th>Amount</th><th>Date</th></tr></thead>
                <tbody>
                    @foreach($recentTransactions as $t)
                    <tr>
                        <td style="font-family:'Playfair Display',serif;">{{ $t->invoice_number }}</td>
                        <td>{{ $t->client->first_name }} {{ $t->client->last_name }}</td>
                        <td>₱{{ number_format($t->amount,2) }}</td>
                        <td style="color:var(--gray-mid);">{{ $t->created_at->format('M d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card" style="padding:0;">
            <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--gray-pale);"><p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);">Inventory by Status</p></div>
            <table class="gt-table">
                <thead><tr><th>Status</th><th>Count</th></tr></thead>
                <tbody>
                    @foreach($inventoryByStatus as $row)
                    <tr>
                        <td><span class="badge badge-{{ $row->status }}">{{ $row->status }}</span></td>
                        <td>{{ $row->count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>