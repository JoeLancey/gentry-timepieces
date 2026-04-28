<x-app-layout header="Clients">
    <x-slot:actions><a href="{{ route('clients.create') }}" class="btn btn-primary">+ New Client</a></x-slot:actions>
    <div class="card" style="padding:0;">
        @if($clients->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr><th>Name</th><th>Phone</th><th>Email</th><th>Address</th><th>Added</th><th></th></tr></thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td><strong>{{ $client->first_name }} {{ $client->last_name }}</strong></td>
                        <td>{{ $client->phone }}</td>
                        <td style="color:var(--gray-mid);">{{ $client->email ?? '—' }}</td>
                        <td style="color:var(--gray-mid);max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $client->address ?? '—' }}</td>
                        <td style="color:var(--gray-mid);">{{ $client->created_at->format('M d, Y') }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:0.5rem;justify-content:flex-end;">
                                <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary btn-sm">View</a>
                                <a href="{{ route('clients.edit', $client) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Delete this client?')">
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
        <div style="padding:1.25rem 1.5rem;border-top:1px solid var(--gray-pale);">{{ $clients->links() }}</div>
        @else
        <div class="empty-state"><p>No clients registered yet.</p><a href="{{ route('clients.create') }}" class="btn btn-primary">Add First Client</a></div>
        @endif
    </div>
</x-app-layout>