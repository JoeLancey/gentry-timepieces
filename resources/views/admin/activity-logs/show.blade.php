<x-app-layout header="Activity Log Details">
    <x-slot:actions>
        <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">← Back to Logs</a>
    </x-slot:actions>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <!-- Log Details -->
        <div class="card">
            <div style="padding: 0; border-bottom: 1px solid var(--gray-light);">
                <div style="padding: 1.5rem;">
                    <h2 style="margin: 0 0 0.5rem 0; font-size: 1.25rem;">Activity Details</h2>
                    <p style="margin: 0; color: var(--gray-mid); font-size: 0.875rem;">Log ID: #{{ $log->id }}</p>
                </div>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: grid; gap: 1.5rem; font-size: 0.875rem;">
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Action</span>
                        <p style="margin: 0.25rem 0 0 0;">
                            <span style="display: inline-block; padding: 0.35rem 0.75rem; border-radius: 3px; font-weight: 600; background: #f0f0f0;">
                                {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Model Type</span>
                        <p style="margin: 0.25rem 0 0 0;"><strong>{{ $log->model_type }}</strong></p>
                    </div>
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Model ID</span>
                        <p style="margin: 0.25rem 0 0 0;">#{{ $log->model_id }}</p>
                    </div>
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Performed By</span>
                        <p style="margin: 0.25rem 0 0 0;"><strong>{{ $log->user->name }}</strong></p>
                        <p style="margin: 0; font-size: 0.8125rem; color: var(--gray-mid);">{{ $log->user->email }}</p>
                    </div>
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Timestamp</span>
                        <p style="margin: 0.25rem 0 0 0;">{{ $log->created_at->format('F d, Y \a\t H:i:s') }}</p>
                    </div>
                    <div>
                        <span style="color: var(--gray-mid); font-weight: 500;">Description</span>
                        <p style="margin: 0.25rem 0 0 0;">{{ $log->description ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Changes -->
        @if($log->changes)
        <div class="card">
            <div style="padding: 0; border-bottom: 1px solid var(--gray-light);">
                <div style="padding: 1.5rem;">
                    <h2 style="margin: 0; font-size: 1.25rem;">Changes</h2>
                </div>
            </div>
            <div style="padding: 1.5rem;">
                @if(is_array($log->changes) && count($log->changes) > 0)
                    <div style="display: grid; gap: 1.5rem;">
                        @foreach($log->changes as $field => $change)
                        <div style="background: #f9f9f9; padding: 1rem; border-radius: 3px; border-left: 3px solid #2196f3;">
                            <p style="margin: 0 0 0.75rem 0; font-weight: 500; font-size: 0.875rem; color: #2196f3;">{{ ucfirst(str_replace('_', ' ', $field)) }}</p>
                            <div style="display: grid; gap: 0.5rem; font-size: 0.8125rem;">
                                <div>
                                    <span style="color: var(--gray-mid);">Before:</span>
                                    <p style="margin: 0.25rem 0 0 0; font-family: monospace; background: #fff; padding: 0.5rem; border-radius: 2px;">
                                        {{ $change['old'] ?? '—' }}
                                    </p>
                                </div>
                                <div>
                                    <span style="color: var(--gray-mid);">After:</span>
                                    <p style="margin: 0.25rem 0 0 0; font-family: monospace; background: #fff; padding: 0.5rem; border-radius: 2px;">
                                        {{ $change['new'] ?? '—' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                <p style="color: var(--gray-mid); font-size: 0.875rem;">No specific changes recorded.</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
