<x-app-layout header="Clients">
    <x-slot:actions><a href="{{ route('clients.create') }}" class="btn btn-primary">+ New Client</a></x-slot:actions>

    <x-alert />

    <div class="card" style="padding: 0;">
        <!-- Search -->
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-light);">
            <form method="GET" style="display: flex; gap: 1rem;">
                <input type="text" name="search" placeholder="Search by name, phone, email..." value="{{ request('search') }}"
                    style="flex: 1; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px;">
                <button type="submit" class="btn btn-secondary">Search</button>
                @if(request('search'))
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Clear</a>
                @endif
            </form>
        </div>

        @if($clients->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Transactions</th>
                    <th>Total Spent</th>
                    <th>Added</th>
                    <th>Actions</th>
                </tr></thead>
                <tbody>
                @foreach($clients as $client)
                <tr>
                    <td><strong>{{ $client->full_name }}</strong></td>
                    <td>{{ $client->phone }}</td>
                    <td style="color: var(--gray-mid);">{{ $client->email ?? '—' }}</td>
                    <td>{{ $client->transactions_count }}</td>
                    <td>
                        @php
                            $total = $client->transactions()->sum('amount');
                        @endphp
                        ${{ number_format($total, 2) }}
                    </td>
                    <td style="color: var(--gray-mid);">{{ $client->created_at->format('M d, Y') }}</td>
                    <td style="text-align:right;">
                        <div style="display:flex;gap:0.5rem;justify-content:flex-end;flex-wrap:wrap;">
                            <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary btn-sm">View Profile</a>
                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Delete this client?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding: 1rem;">
            {{ $clients->links() }}
        </div>
        @else
        <div style="padding: 3rem; text-align: center; color: var(--gray-mid);">
            <p>No clients found. <a href="{{ route('clients.create') }}">Add one now</a></p>
        </div>
        @endif
    </div>
</x-app-layout>