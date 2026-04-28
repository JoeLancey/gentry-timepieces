<x-app-layout header="Inventory">
    <x-slot:actions>
        <a href="{{ route('watches.create') }}" class="btn btn-primary">+ Add Watch</a>
    </x-slot:actions>

    <x-alert />

    @if(isset($db_error))
        <div class="card" style="background:#fff4f4;border:1px solid #f5c2c7;padding:0.75rem;color:#611a15;margin-bottom:1rem;">
            <strong>Warning:</strong> {{ $db_error }}
        </div>
    @endif

    <div class="card" style="padding: 0;">
        <!-- Search & Filter -->
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-light); display: flex; gap: 1rem; flex-wrap: wrap;">
            <form method="GET" style="display: flex; gap: 1rem; flex: 1; min-width: 300px;">
                <input type="text" name="search" placeholder="Search serial, brand..." value="{{ request('search') }}" 
                    style="flex: 1; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px;">
                <select name="status" style="padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px;">
                    <option value="">All Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                    <option value="consigned" {{ request('status') == 'consigned' ? 'selected' : '' }}>Consigned</option>
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>

        <!-- Table -->
        @if($watches->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr>
                    <th>Brand / Model</th>
                    <th>Serial No.</th>
                    <th>Year</th>
                    <th>Condition</th>
                    <th>Asking Price</th>
                    <th>Cost</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr></thead>
                <tbody>
                @foreach($watches as $watch)
                <tr>
                    <td><strong>{{ $watch->brand }} {{ $watch->model }}</strong></td>
                    <td>{{ $watch->serial_number }}</td>
                    <td>{{ $watch->year_produced ?? '—' }}</td>
                    <td><span style="text-transform: capitalize;">{{ $watch->condition }}</span></td>
                    <td>${{ number_format($watch->asking_price, 2) }}</td>
                    <td>${{ number_format($watch->cost_price, 2) }}</td>
                    <td><x-status-badge :status="$watch->status" /></td>
                    <td>
                        <a href="{{ route('watches.show', $watch) }}" class="btn-link">View</a>
                        <a href="{{ route('watches.edit', $watch) }}" class="btn-link">Edit</a>
                        <form method="POST" action="{{ route('watches.destroy', $watch) }}" style="display:inline;" onsubmit="return confirm('Delete this watch?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-link" style="color: #d32f2f;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding: 1rem;">
            {{ $watches->links() }}
        </div>
        @else
        <div style="padding: 3rem; text-align: center; color: var(--gray-mid);">
            <p>No watches found. <a href="{{ route('watches.create') }}">Add one now</a></p>
        </div>
        @endif
    </div>
</x-app-layout>