<x-app-layout header="Users">
    <x-slot:actions>
        <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add Staff</a>
    </x-slot:actions>

    <x-alert />

    <div class="card overflow-hidden p-0">
        @if($users->count())
            <div class="table-container border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td>
                                <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                            </td>
                            <td class="text-gray-500">{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role }}">{{ $user->role }}</span>
                            </td>
                            <td>
                                @if($user->approved)
                                    <span class="badge badge-active">Approved</span>
                                @else
                                    <span class="badge badge-pending">Pending</span>
                                @endif
                            </td>
                            <td class="text-gray-500 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                @if(auth()->user()->isAdmin() && !$user->approved && auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('users.approve', $user) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve this user?')">Approve</button>
                                </form>
                                @endif
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary btn-sm">Edit</a>
                                @if(auth()->user()->isAdmin() && auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                @endif
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    @if(auth()->user()->isAdmin() && auth()->id() !== $user->id)
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')" style="display:inline;">
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
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h4 class="empty-title">No users found</h4>
                <p class="empty-text">Add staff members to manage your timepiece business.</p>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add Staff</a>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>