<x-app-layout header="Activity Audit Trail">
    <x-slot:actions>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">← Back to Reports</a>
    </x-slot:actions>

    <x-alert />

    <div class="card" style="padding: 0; margin-bottom: 1.5rem;">
        <!-- Filters -->
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-light);">
            <form method="GET" style="display: grid; gap: 1rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Model Type</label>
                        <select name="model_type" style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; box-sizing: border-box;">
                            <option value="">All Models</option>
                            @foreach($modelTypes as $type)
                                <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Action</label>
                        <select name="action" style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; box-sizing: border-box;">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $action)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-secondary" style="flex: 1; min-width: 150px;">Filter</button>
                    <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary" style="flex: 1; min-width: 150px; text-align: center; text-decoration: none; padding: 0.625rem;">Clear</a>
                </div>
            </form>
        </div>

        <!-- Logs Table -->
        @if($logs->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Model</th>
                    <th>Description</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr></thead>
                <tbody>
                @foreach($logs as $log)
                <tr>
                    <td>
                        <strong>{{ $log->user->name ?? 'System' }}</strong>
                        <p style="margin: 0.25rem 0 0 0; font-size: 0.8125rem; color: var(--gray-mid);">{{ $log->user->email ?? '—' }}</p>
                    </td>
                    <td>
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.75rem; font-weight: 600;
                            background: {{ 
                                match($log->action) {
                                    'created' => '#e8f5e9',
                                    'updated' => '#e3f2fd',
                                    'deleted' => '#ffebee',
                                    'restored' => '#f3e5f5',
                                    'approved' => '#c8e6c9',
                                    default => '#f5f5f5'
                                }
                            }};
                            color: {{
                                match($log->action) {
                                    'created' => '#2e7d32',
                                    'updated' => '#1565c0',
                                    'deleted' => '#c62828',
                                    'restored' => '#6a1b9a',
                                    'approved' => '#1b5e20',
                                    default => '#424242'
                                }
                            }};">
                            {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                        </span>
                    </td>
                    <td>
                        <strong>{{ $log->model_type }}</strong>
                        <p style="margin: 0.25rem 0 0 0; font-size: 0.8125rem; color: var(--gray-mid);">ID: #{{ $log->model_id }}</p>
                    </td>
                    <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $log->description ?? '—' }}
                    </td>
                    <td style="color: var(--gray-mid); font-size: 0.875rem;">
                        {{ $log->created_at->format('M d, Y H:i') }}
                    </td>
                    <td>
                        <a href="{{ route('activity-logs.show', $log) }}" class="btn-link">Details</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding: 1rem;">
            {{ $logs->links() }}
        </div>
        @else
        <div style="padding: 3rem; text-align: center; color: var(--gray-mid);">
            <p>No activity logs found.</p>
        </div>
        @endif
    </div>
</x-app-layout>
