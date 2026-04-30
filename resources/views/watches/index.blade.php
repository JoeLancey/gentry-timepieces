<x-app-layout header="Inventory">
    <x-slot:actions>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('watches.create') }}" class="btn btn-primary">+ Add Watch</a>
        @endif
    </x-slot:actions>

    <x-alert />

    @if(isset($db_error))
        <div class="card bg-red-50 border border-red-200 p-4 mb-6" role="alert">
            <strong class="font-semibold text-red-800">Warning:</strong> <span class="text-red-700">{{ $db_error }}</span>
        </div>
    @endif

    <!-- Filter Panel -->
    <div class="filter-section">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-900">Advanced Filters</h3>
            <button type="button" onclick="toggleFilters()" class="btn btn-ghost sm:hidden">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filters
            </button>
        </div>

        <form method="GET" id="filterForm" class="filter-form">
            <div class="filter-group">
                <label class="form-label">Search</label>
                <input type="text" name="search" placeholder="Serial, brand, model..." value="{{ request('search') }}"
                    class="form-input">
            </div>

            <div class="filter-group">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" placeholder="e.g. Rolex, Omega..." value="{{ request('brand') }}"
                    class="form-input">
            </div>

            <div class="filter-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label class="form-label">Condition</label>
                <select name="condition" class="form-select">
                    <option value="">All Conditions</option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition }}" {{ request('condition') == $condition ? 'selected' : '' }}>
                            {{ ucfirst($condition) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label class="form-label">Min Price</label>
                <input type="number" name="price_min" placeholder="0" value="{{ request('price_min') }}"
                    class="form-input">
            </div>

            <div class="filter-group">
                <label class="form-label">Max Price</label>
                <input type="number" name="price_max" placeholder="999999" value="{{ request('price_max') }}"
                    class="form-input">
            </div>

            <div class="filter-group">
                <label class="form-label">Year From</label>
                <input type="number" name="year_from" placeholder="1950" value="{{ request('year_from') }}"
                    class="form-input">
            </div>

            <div class="filter-group">
                <label class="form-label">Year To</label>
                <input type="number" name="year_to" placeholder="2026" value="{{ request('year_to') }}"
                    class="form-input">
            </div>

            <div class="filter-group flex gap-2">
                <button type="submit" class="btn btn-primary flex-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Apply
                </button>
                <a href="{{ route('watches.index') }}" class="btn btn-secondary" title="Clear Filters">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
        </form>

        <!-- Saved Filters -->
        @if($filters->count())
        <div class="mt-4 pt-4 border-t border-gray-200">
            <p class="text-sm font-medium text-gray-700 mb-2">Saved Filters:</p>
            <div class="flex flex-wrap gap-2">
                @foreach($filters as $filter)
                    <a href="{{ route('watches.applyFilter', $filter) }}"
                       class="btn btn-sm btn-secondary">
                        {{ $filter->name }}
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="card p-5 mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900 tracking-tight">Manage your inventory</h2>
            <p class="text-sm text-gray-500 mt-1">Add new watches to track and manage your collection with detailed information.</p>
        </div>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('watches.create') }}" class="btn btn-primary justify-center">
                + Add Watch
            </a>
        @endif
    </div>

    <!-- Bulk Actions Bar -->
    <div id="bulkActionsBar" class="card bg-gray-50 border border-gray-200 p-4 mb-6 hidden" x-show="bulkSelected">
        <div class="flex flex-wrap items-center gap-4">
            <span id="bulkCount" class="font-semibold text-gray-900"></span>

            @if(auth()->user()->isAdmin())
            <form id="bulkActionForm" method="POST" action="{{ route('watches.bulkAction') }}" class="flex items-center gap-2">
                @csrf
                <input type="hidden" id="bulkWatchIds" name="watch_ids" value="">
                <select name="action" class="form-select text-sm py-1 px-3">
                    <option value="">Select Action...</option>
                    <option value="available">Mark Available</option>
                    <option value="sold">Mark Sold</option>
                    <option value="consigned">Mark Consigned</option>
                    <option value="reserved">Mark Reserved</option>
                    <option value="delete">Delete</option>
                </select>
                <button type="submit" class="btn btn-sm btn-secondary" onclick="if(confirm('Apply bulk action?')) this.form.submit(); return false;">
                    Apply
                </button>
            </form>

            <form id="bulkPriceForm" method="POST" action="{{ route('watches.bulkPrice') }}" class="flex items-center gap-2">
                @csrf
                <input type="hidden" id="bulkPriceWatchIds" name="watch_ids" value="">
                <input type="number" name="price_adjustment" placeholder="Amount" step="0.01"
                       class="form-input text-sm w-32">
                <select name="price_type" class="form-select text-sm py-1 px-2">
                    <option value="fixed">Fixed</option>
                    <option value="percentage">%</option>
                </select>
                <button type="submit" class="btn btn-sm btn-secondary" onclick="if(confirm('Update prices?')) this.form.submit(); return false;">
                    Update Prices
                </button>
            </form>
            @endif

            <button type="button" class="btn btn-sm btn-ghost" onclick="clearBulkSelection()">
                Cancel
            </button>
        </div>
    </div>

    <!-- Table -->
    @if($watches->count())
        <div class="card overflow-hidden p-0">
            <div class="table-container border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 48px;">
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" class="w-4 h-4 accent-gray-900">
                            </th>
                            <th>Brand / Model</th>
                            <th>Serial No.</th>
                            <th>Year</th>
                            <th>Condition</th>
                            <th class="text-right">Asking Price</th>
                            @if(auth()->user()->isAdmin())
                                <th class="text-right">Cost</th>
                            @endif
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($watches as $watch)
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td>
                                <input type="checkbox" class="watchCheckbox w-4 h-4 accent-gray-900" value="{{ $watch->id }}" onchange="updateBulkSelection()">
                            </td>
                            <td>
                                <div class="watch-info">
                                    <strong class="text-gray-900">{{ $watch->brand }} {{ $watch->model }}</strong>
                                </div>
                            </td>
                            <td class="font-mono text-sm text-gray-600">{{ $watch->serial_number }}</td>
                            <td class="text-gray-700">{{ $watch->year_produced ?? '—' }}</td>
                            <td class="capitalize text-gray-700">{{ $watch->condition }}</td>
                            <td class="text-right font-semibold text-gray-900">${{ number_format($watch->asking_price, 2) }}</td>
                            @if(auth()->user()->isAdmin())
                                <td class="text-right font-semibold text-gray-700">₱{{ number_format($watch->cost_price, 2) }}</td>
                            @endif
                            <td><x-status-badge :status="$watch->status" /></td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('watches.show', $watch) }}" class="btn btn-ghost text-sm" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('watches.edit', $watch) }}" class="btn btn-ghost text-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('watches.destroy', $watch) }}" style="display:inline;" onsubmit="return confirm('Delete this watch?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-ghost text-danger text-sm" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $watches->links() }}
            </div>
        </div>
    @else
        <div class="card">
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h4 class="empty-title">No watches found</h4>
                <p class="empty-text">Get started by adding your first timepiece to inventory.</p>
                <a href="{{ route('watches.create') }}" class="btn btn-primary">+ Add Watch</a>
            </div>
        </div>
    @endif

    <!-- Save Filter Modal -->
    <div id="saveFilterModal"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
         style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Save Current Filter</h3>
            <form method="POST" action="{{ route('watches.saveFilter') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <input type="hidden" name="condition" value="{{ request('condition') }}">
                <input type="hidden" name="brand" value="{{ request('brand') }}">
                <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                <input type="hidden" name="price_max" value="{{ request('price_max') }}">
                <input type="hidden" name="year_from" value="{{ request('year_from') }}">
                <input type="hidden" name="year_to" value="{{ request('year_to') }}">

                <div class="form-group">
                    <label class="form-label">Filter Name</label>
                    <input type="text" name="filter_name" placeholder="e.g. High-Value Inventory"
                           class="form-input" required>
                </div>

                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" class="btn btn-secondary" onclick="closeSaveModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Filter</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleSelectAll(checkbox) {
            document.querySelectorAll('.watchCheckbox').forEach(cb => cb.checked = checkbox.checked);
            updateBulkSelection();
        }

        function updateBulkSelection() {
            const selected = document.querySelectorAll('.watchCheckbox:checked');
            const bulkBar = document.getElementById('bulkActionsBar');
            const bulkCount = document.getElementById('bulkCount');
            const watchIds = Array.from(selected).map(cb => cb.value).join(',');
            
            document.getElementById('bulkWatchIds').value = watchIds;
            document.getElementById('bulkPriceWatchIds').value = watchIds;

            if (selected.length > 0) {
                bulkBar.classList.remove('hidden');
                bulkCount.textContent = `${selected.length} watch${selected.length !== 1 ? 'es' : ''} selected`;
                document.getElementById('selectAll').checked = document.querySelectorAll('.watchCheckbox').length === selected.length;
            } else {
                bulkBar.classList.add('hidden');
                document.getElementById('selectAll').checked = false;
            }
        }

        function clearBulkSelection() {
            document.querySelectorAll('.watchCheckbox').forEach(cb => cb.checked = false);
            updateBulkSelection();
        }

        function closeSaveModal() {
            document.getElementById('saveFilterModal').style.display = 'none';
        }

        function toggleFilters() {
            const form = document.getElementById('filterForm');
            const isHidden = form.style.display === 'none';
            form.style.display = isHidden ? 'grid' : 'none';
        }

        // Mobile filter visibility
        if (window.innerWidth < 768) {
            document.getElementById('filterForm').style.display = 'none';
        }
    </script>
    @endpush
</x-app-layout>