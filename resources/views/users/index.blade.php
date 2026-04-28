<x-app-layout>
    <x-slot name="header">Users</x-slot>
    <x-slot name="actions"><a href="{{ route('users.create') }}" class="btn btn-primary">+ Add Staff</a></x-slot>
    <div class="card" style="padding:0;">
        @if($users->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Joined</th><th></th></tr></thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td style="color:var(--gray-mid);">{{ $user->email }}</td>
                        <td><span class="badge badge-{{ $user->role }}">{{ $user->role }}</span></td>
                        <td>
                            @if($user->approved)
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td style="color:var(--gray-mid);">{{ $user->created_at->format('M d, Y') }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:0.5rem;justify-content:flex-end;flex-wrap:wrap;">
                                @if(!$user->approved && auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('users.approve', $user) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                @endif
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary btn-sm">Edit</a>
                                @if(auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">Delete</button></form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state"><p>No users found.</p></div>
        @endif
    </div>
</x-app-layout>