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

    <div class="card" style="padding: 0; margin-bottom: 1rem;">
        <!-- Filter Panel -->
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-light);">
            <div style="margin-bottom: 1rem;">
                <h3 style="margin: 0 0 1rem 0; font-size: 1rem; font-weight: 600;">Advanced Filters</h3>
            </div>

            <form method="GET" style="display: grid; gap: 1rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Search</label>
                        <input type="text" name="search" placeholder="Serial, brand, model..." value="{{ request('search') }}"
                            style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Brand</label>
                        <input type="text" name="brand" placeholder="e.g. Rolex, Omega..." value="{{ request('brand') }}"
                            style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Status</label>
                        <select name="status" style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; box-sizing: border-box;">
                            <option value="">All Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Condition</label>
                        <select name="condition" style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; box-sizing: border-box;">
                            <option value="">All Conditions</option>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition }}" {{ request('condition') == $condition ? 'selected' : '' }}>
                                    {{ ucfirst($condition) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Min Price</label>
                        <input type="number" name="price_min" placeholder="0" value="{{ request('price_min') }}"
                            style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Max Price</label>
                        <input type="number" name="price_max" placeholder="999999" value="{{ request('price_max') }}"
                            style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Year From</label>
                        <input type="number" name="year_from" placeholder="1950" value="{{ request('year_from') }}"
                            style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Year To</label>
                        <input type="number" name="year_to" placeholder="2026" value="{{ request('year_to') }}"
                            style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; box-sizing: border-box;">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <button type="submit" class="btn btn-secondary" style="flex: 1; min-width: 150px;">Apply Filters</button>
                    <a href="{{ route('watches.index') }}" class="btn btn-secondary" style="flex: 1; min-width: 150px; text-align: center; text-decoration: none; padding: 0.625rem;">Clear Filters</a>
                    
                    <!-- Save filter modal trigger -->
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('saveFilterModal').style.display='flex'" style="flex: 1; min-width: 150px;">Save Filter</button>
                </div>
            </form>

            <!-- Saved Filters -->
            @if($filters->count())
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-light);">
                <p style="font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Saved Filters:</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    @foreach($filters as $filter)
                        <a href="{{ route('watches.applyFilter', $filter) }}" class="btn btn-sm" 
                            style="padding: 0.5rem 0.75rem; font-size: 0.875rem; background: #f5f5f5; border: 1px solid var(--gray-light); cursor: pointer;">
                            {{ $filter->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Bulk Actions Bar (visible when watches are selected) -->
        <div id="bulkActionsBar" style="padding: 1rem; border-bottom: 1px solid var(--gray-light); background: #f9f9f9; display: none;">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                <span id="bulkCount" style="font-weight: 500;"></span>
                
                <!-- Bulk Status Change -->
                <form id="bulkActionForm" method="POST" action="{{ route('watches.bulkAction') }}" style="display: flex; gap: 0.5rem; align-items: center;">
                    @csrf
                    <input type="hidden" id="bulkWatchIds" name="watch_ids" value="">
                    <select name="action" style="padding: 0.5rem; border: 1px solid var(--gray-light); border-radius: 3px;">
                        <option value="">Select Action...</option>
                        <option value="available">Mark Available</option>
                        <option value="sold">Mark Sold</option>
                        <option value="consigned">Mark Consigned</option>
                        <option value="reserved">Mark Reserved</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-secondary" onclick="if(confirm('Apply bulk action?')) this.form.submit(); return false;">Apply Action</button>
                </form>

                <!-- Bulk Price Update -->
                <form id="bulkPriceForm" method="POST" action="{{ route('watches.bulkPrice') }}" style="display: flex; gap: 0.5rem; align-items: center;">
                    @csrf
                    <input type="hidden" id="bulkPriceWatchIds" name="watch_ids" value="">
                    <input type="number" name="price_adjustment" placeholder="Amount" step="0.01" style="width: 100px; padding: 0.5rem; border: 1px solid var(--gray-light); border-radius: 3px;">
                    <select name="price_type" style="padding: 0.5rem; border: 1px solid var(--gray-light); border-radius: 3px;">
                        <option value="fixed">Fixed</option>
                        <option value="percentage">Percentage %</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-secondary" onclick="if(confirm('Update prices?')) this.form.submit(); return false;">Update Prices</button>
                </form>

                <button type="button" class="btn btn-sm btn-secondary" onclick="clearBulkSelection()">Cancel</button>
            </div>
        </div>

        <!-- Table -->
        @if($watches->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr>
                    <th style="width: 40px;"><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"></th>
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
                    <td><input type="checkbox" class="watchCheckbox" value="{{ $watch->id }}" onchange="updateBulkSelection()"></td>
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

    <!-- Save Filter Modal -->
    <div id="saveFilterModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background: white; padding: 2rem; border-radius: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); max-width: 400px;">
            <h3 style="margin: 0 0 1rem 0;">Save Current Filter</h3>
            <form method="POST" action="{{ route('watches.saveFilter') }}" style="display: flex; flex-direction: column; gap: 1rem;">
                @csrf
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <input type="hidden" name="condition" value="{{ request('condition') }}">
                <input type="hidden" name="brand" value="{{ request('brand') }}">
                <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                <input type="hidden" name="price_max" value="{{ request('price_max') }}">
                <input type="hidden" name="year_from" value="{{ request('year_from') }}">
                <input type="hidden" name="year_to" value="{{ request('year_to') }}">
                
                <input type="text" name="filter_name" placeholder="e.g. High-Value Inventory" required
                    style="padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px;">
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('saveFilterModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Filter</button>
                </div>
            </form>
        </div>
    </div>

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
                bulkBar.style.display = 'block';
                bulkCount.textContent = `${selected.length} watch${selected.length !== 1 ? 'es' : ''} selected`;
                document.getElementById('selectAll').checked = document.querySelectorAll('.watchCheckbox').length === selected.length;
            } else {
                bulkBar.style.display = 'none';
                document.getElementById('selectAll').checked = false;
            }
        }

        function clearBulkSelection() {
            document.querySelectorAll('.watchCheckbox').forEach(cb => cb.checked = false);
            updateBulkSelection();
        }
    </script>
</x-app-layout>