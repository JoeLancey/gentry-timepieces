<x-app-layout header="Clients">
    <x-slot:actions>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">+ New Client</a>
    </x-slot:actions>

    <x-alert />

    <!-- Search -->
    <div class="filter-section">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Search by name, phone, email..."
                       value="{{ request('search') }}"
                       class="form-input">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Clear</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card overflow-hidden p-0">
        @if($clients->count())
            <div class="table-container border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Transactions</th>
                            <th>Total Spent</th>
                            <th>Added</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td>
                                <div class="font-semibold text-gray-900">{{ $client->full_name }}</div>
                            </td>
                            <td class="text-gray-700">{{ $client->phone }}</td>
                            <td class="text-gray-500">{{ $client->email ?? '—' }}</td>
                            <td class="font-medium">{{ $client->transactions_count }}</td>
                            <td class="text-right font-semibold text-gray-900">
                                ${{ number_format($client->transactions()->sum('amount'), 2) }}
                            </td>
                            <td class="text-gray-500 text-sm">{{ $client->created_at->format('M d, Y') }}</td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary btn-sm">View</a>
                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-ghost text-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Delete this client?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-ghost text-danger text-sm" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $clients->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h4 class="empty-title">No clients found</h4>
                <p class="empty-text">Add clients to track their purchases and consignments.</p>
                <a href="{{ route('clients.create') }}" class="btn btn-primary">+ New Client</a>
            </div>
        @endif
    </div>
</x-app-layout>