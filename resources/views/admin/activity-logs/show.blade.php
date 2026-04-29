<x-app-layout header="Activity Log Details">
    <x-slot:actions>
        <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">← Back to Logs</a>
    </x-slot:actions>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Log Details -->
        <div class="lg:col-span-2">
            <div class="card p-6">
                <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 tracking-tight">Activity Details</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Log ID: #{{ $log->id }}</p>
                    </div>
                    <span class="badge" style="background: {{
                        match($log->action) {
                            'created' => '#dcfce7',
                            'updated' => '#dbeafe',
                            'deleted' => '#fee2e2',
                            'restored' => '#f3e8ff',
                            'approved' => '#bbf7d0',
                            default => '#f3f4f6'
                        }
                    }}; color: {{
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
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="detail-box">
                        <span class="detail-label">Model Type</span>
                        <span class="detail-value font-semibold">{{ class_basename($log->model_type) }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Model ID</span>
                        <span class="detail-value font-mono">#{{ $log->model_id }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Performed By</span>
                        <span class="detail-value font-semibold">{{ $log->user->name }}</span>
                        <span class="text-sm text-gray-500">{{ $log->user->email }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Timestamp</span>
                        <span class="detail-value">{{ $log->created_at->format('F d, Y \a\t H:i:s') }}</span>
                    </div>
                </div>

                @if($log->description)
                <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg border-l-4 border-l-gray-900">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Description</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $log->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar - Changes if any -->
        <div class="space-y-6">
            @if($log->changes && is_array($log->changes) && count($log->changes) > 0)
            <div class="card p-5">
                <h3 class="text-base font-bold text-gray-900 mb-4">Changes Made</h3>
                <div class="space-y-4">
                    @foreach($log->changes as $field => $change)
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 border-l-4 border-l-blue-600">
                            <p class="font-semibold text-gray-900 mb-2" style="font-size: 0.875rem;">
                                {{ ucfirst(str_replace('_', ' ', $field)) }}
                            </p>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="text-gray-500 text-xs uppercase tracking-wider">Before:</span>
                                    <p class="mt-0.5 p-2 bg-white border border-gray-200 rounded font-mono text-xs">
                                        {{ $change['old'] ?? '—' }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-gray-500 text-xs uppercase tracking-wider">After:</span>
                                    <p class="mt-0.5 p-2 bg-white border border-gray-200 rounded font-mono text-xs">
                                        {{ $change['new'] ?? '—' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="card p-5">
                <p class="text-gray-500 text-sm">No change details recorded for this log entry.</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
