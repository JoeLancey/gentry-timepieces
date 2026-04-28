<x-app-layout header="Dashboard">
    <x-slot:actions>
        <a href="{{ route('watches.create') }}" class="btn btn-primary">+ Add Watch</a>
    </x-slot:actions>

    <div class="stats-grid">
        @if(isset($db_error))
            <div class="card" style="grid-column:1/-1; background:#fff4f4; border:1px solid #f5c2c7; padding:0.75rem; color:#611a15;">
                <strong>Warning:</strong> {{ $db_error }}
            </div>
        @endif
        <div class="stat-card"><p class="stat-label">Total Watches</p><p class="stat-value">{{ $totalWatches }}</p></div>
        <div class="stat-card"><p class="stat-label">Available</p><p class="stat-value green">{{ $availableWatches }}</p></div>
        <div class="stat-card"><p class="stat-label">Clients</p><p class="stat-value">{{ $totalClients }}</p></div>
        <div class="stat-card"><p class="stat-label">Total Sales</p><p class="stat-value blue">{{ $totalSales }}</p></div>
        <div class="stat-card"><p class="stat-label">Consignments</p><p class="stat-value purple">{{ $activeConsignments }}</p></div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
        <div class="card">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gray-mid);margin-bottom:1.25rem;">Quick Actions</p>
            <div style="display:flex;flex-direction:column;gap:0.5rem;">
                <a href="{{ route('watches.create') }}" class="btn btn-secondary" style="justify-content:center;">Add Watch to Inventory</a>
                <a href="{{ route('clients.create') }}" class="btn btn-secondary" style="justify-content:center;">Register New Client</a>
                <a href="{{ route('appraisals.create') }}" class="btn btn-secondary" style="justify-content:center;">Create Appraisal</a>
                <a href="{{ route('consignments.create') }}" class="btn btn-secondary" style="justify-content:center;">New Consignment</a>
                <a href="{{ route('transactions.create') }}" class="btn btn-secondary" style="justify-content:center;">Record Transaction</a>
            </div>
        </div>
        <div class="card" style="background:var(--black);color:var(--white);">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:#444;margin-bottom:1.25rem;">System Info</p>
            <div style="display:flex;flex-direction:column;gap:1rem;">
                <div><p style="font-size:0.6rem;letter-spacing:0.15em;text-transform:uppercase;color:#444;margin-bottom:0.25rem;">Signed In</p><p style="font-size:0.88rem;color:#ccc;">{{ auth()->user()->name }}</p></div>
                <div><p style="font-size:0.6rem;letter-spacing:0.15em;text-transform:uppercase;color:#444;margin-bottom:0.25rem;">Role</p><p style="font-size:0.88rem;color:#ccc;text-transform:capitalize;">{{ auth()->user()->role }}</p></div>
                <div><p style="font-size:0.6rem;letter-spacing:0.15em;text-transform:uppercase;color:#444;margin-bottom:0.25rem;">Date</p><p style="font-size:0.88rem;color:#ccc;">{{ now()->format('F d, Y') }}</p></div>
            </div>
        </div>
    </div>
</x-app-layout> 