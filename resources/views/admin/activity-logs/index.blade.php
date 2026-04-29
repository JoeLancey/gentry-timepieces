<x-app-layout header="Activity Audit Trail">
    <x-slot:actions>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">← Back to Reports</a>
    </x-slot:actions>

    <x-alert />

    <!-- Filters -->
    <div class="filter-section">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <label class="form-label">Model Type</label>
                <select name="model_type" class="form-select">
                    <option value="">All Models</option>
                    @foreach($modelTypes as $type)
                        <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label class="form-label">Action</label>
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $action)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">Clear</a>
            </div>
        </form>
    </div>

    <!-- Logs Table -->
    @if($logs->count())
        <div class="card overflow-hidden p-0">
            <div class="table-container border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Model</th>
                            <th>Description</th>
                            <th>Timestamp</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td>
                                <div class="font-semibold text-gray-900">{{ $log->user->name ?? 'System' }}</div>
                                <div class="text-sm text-gray-500">{{ $log->user->email ?? '—' }}</div>
                            </td>
                            <td>
                                <span class="badge"
                                      style="background: {{
                                          match($log->action) {
                                              'created' => '#dcfce7',
                                              'updated' => '#dbeafe',
                                              'deleted' => '#fee2e2',
                                              'restored' => '#f3e8ff',
                                              'approved' => '#bbf7d0',
                                              default => '#f3f4f6'
                                          }
                                      }};
                                      color: {{
                                          match($log->action) {
                                              'created' => '#166534',
                                              'updated' => '#1d4ed8',
                                              'deleted' => '#991b1b',
                                              'restored' => '#7c3aed',
                                              'approved' => '#166534',
                                              default => '#424242'
                                          }
                                      }};">
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td>
                                <div class="font-semibold text-gray-900">{{ class_basename($log->model_type) }}</div>
                                <div class="text-sm text-gray-500">ID: #{{ $log->model_id }}</div>
                            </td>
                            <td class="max-w-xs truncate text-gray-600">
                                {{ $log->description ?? '—' }}
                            </td>
                            <td class="text-gray-500 text-sm">
                                {{ $log->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route('activity-logs.show', $log) }}" class="btn btn-secondary btn-sm">
                                    Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $logs->links() }}
            </div>
        @else
            <div class="card">
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h4 class="empty-title">No activity logs found</h4>
                    <p class="empty-text">System activity will appear here.</p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
