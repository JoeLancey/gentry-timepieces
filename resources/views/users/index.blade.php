<x-app-layout header="User Management">
    <x-slot:actions>
        <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add User</a>
    </x-slot:actions>

    <x-alert />

    <!-- Filter -->
    <div class="card p-4 mb-6">
        <form method="GET" class="flex items-end gap-3">
            <div class="flex-1">
                <label class="form-label">Filter by Role</label>
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            @if(request('role'))
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>
    </div>

    <div class="card overflow-hidden">
        @if($users->count())
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Joined</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="font-semibold text-gray-900">{{ $user->name }}</td>
                            <td class="text-gray-600">{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td>
                                @if($user->isOnline())
                                    <div class="flex items-center gap-2">
                                        <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                                        <span class="text-xs font-semibold text-green-700">Online</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-500">Offline</span>
                                @endif
                            </td>
                            <td class="text-sm text-gray-600">
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->format('M d, h:i A') }}
                                @else
                                    <span class="text-gray-400">Never</span>
                                @endif
                            </td>
                            <td class="text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-secondary btn-sm">View</a>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    @if(auth()->id() !== $user->id)
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user? This cannot be undone.')" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon mb-4">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-1">No users found</h4>
                <p class="text-gray-600 mb-4">Add staff members to manage your timepiece business.</p>
                <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add User</a>
            </div>
        @endif
    </div>
</x-app-layout>