<x-app-layout header="User Profile">
    <x-slot:actions>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit User</a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Info Card -->
        <div class="space-y-4">
            <div class="card">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ $user->name }}</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Email</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Role</p>
                        <span class="badge badge-{{ $user->role }} mt-1">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Status</p>
                        <div class="flex items-center gap-2 mt-1">
                            @if($user->isOnline())
                                <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                                <span class="text-sm font-semibold text-green-700">Online</span>
                            @else
                                <span class="inline-block w-2 h-2 bg-gray-400 rounded-full"></span>
                                <span class="text-sm text-gray-600">Offline</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Last Login</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">
                            @if($user->last_login_at)
                                {{ $user->last_login_at->format('M d, Y h:i A') }}
                            @else
                                <span class="text-gray-400">Never</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Member Since</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            @if(auth()->id() !== $user->id && auth()->user()->isAdmin())
            <div class="card border-red-200 bg-red-50">
                <p class="text-xs text-gray-600 mb-3">Admin actions for this user</p>
                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user? This action cannot be undone.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger w-full">Delete Account</button>
                </form>
            </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- User Actions/Activity -->
            @if($userActivityBy->count())
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Account Changes</h3>
                <div class="space-y-3">
                    @foreach($userActivityBy as $log)
                    <div class="flex items-start gap-3 pb-3 border-b border-gray-200 last:border-0">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                @if($log->action === 'created')
                                    Account Created
                                @elseif($log->action === 'updated')
                                    Account Updated
                                    @if($log->changes && isset($log->changes['role']))
                                        - Role Changed
                                    @endif
                                @elseif($log->action === 'deleted')
                                    Account Deleted
                                @else
                                    {{ ucfirst($log->action) }}
                                @endif
                            </p>
                            <p class="text-xs text-gray-600 mt-1">{{ $log->created_at->format('M d, Y h:i A') }}</p>
                            @if($log->description)
                            <p class="text-sm text-gray-700 mt-1">{{ $log->description }}</p>
                            @endif
                            @if($log->changes && isset($log->changes['role']))
                            <p class="text-xs text-gray-600 mt-1">
                                <strong>Role:</strong> {{ $log->changes['role']['from'] }} → {{ $log->changes['role']['to'] }}
                            </p>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 whitespace-nowrap">
                            by {{ $log->user?->name ?? 'System' }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @if($userActivityBy->hasMorePages())
                <a href="{{ route('activity-logs.index', ['user_id' => $user->id]) }}" class="btn btn-secondary btn-sm mt-4">View All Changes</a>
                @endif
            </div>
            @endif

            <!-- Transactions -->
            @if($transactions->count())
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Transactions</h3>
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>
                                    <a href="{{ route('transactions.show', $transaction) }}" class="font-mono text-sm font-semibold text-blue-600 hover:underline">
                                        {{ $transaction->invoice_number }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $transaction->type }}">{{ str_replace('_', ' ', ucfirst($transaction->type)) }}</span>
                                </td>
                                <td class="font-semibold text-gray-900">₱{{ number_format($transaction->amount, 2) }}</td>
                                <td class="text-sm text-gray-600">{{ $transaction->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($transactions->hasMorePages())
                <a href="{{ route('transactions.index', ['staff' => $user->id]) }}" class="btn btn-secondary btn-sm mt-4">View All Transactions</a>
                @endif
            </div>
            @else
            <div class="card">
                <div class="empty-state py-8">
                    <p class="text-gray-600">No transactions recorded yet.</p>
                </div>
            </div>
            @endif

            <!-- Activity Log -->
            @if($activityLogs->count())
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">User Activity</h3>
                <div class="space-y-3">
                    @foreach($activityLogs as $log)
                    <div class="flex items-start gap-3 pb-3 border-b border-gray-200 last:border-0">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                {{ ucfirst($log->action) }} {{ strtolower($log->model_type) }}
                                @if($log->model_type === 'Transaction')
                                    - {{ str_replace('_', ' ', ucfirst($log->changes['type'] ?? 'Transaction')) }}
                                @endif
                            </p>
                            <p class="text-xs text-gray-600 mt-1">{{ $log->created_at->format('M d, Y h:i A') }}</p>
                            @if($log->description)
                            <p class="text-sm text-gray-700 mt-1">{{ $log->description }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($activityLogs->hasMorePages())
                <a href="{{ route('activity-logs.index', ['user_id' => $user->id]) }}" class="btn btn-secondary btn-sm mt-4">View All Activity</a>
                @endif
            </div>
            @else
            <div class="card">
                <div class="empty-state py-8">
                    <p class="text-gray-600">No activity recorded yet.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
