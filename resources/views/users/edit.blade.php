<x-app-layout header="Edit User">
    <x-slot:actions><a href="{{ route('users.index') }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    <div class="card" style="max-width:500px;">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-group"><label class="gt-label">Name *</label><input type="text" name="name" class="gt-input" value="{{ old('name',$user->name) }}" required></div>
                <div class="form-group"><label class="gt-label">Email *</label><input type="email" name="email" class="gt-input" value="{{ old('email',$user->email) }}" required></div>
                <div class="form-group"><label class="gt-label">New Password</label><input type="password" name="password" class="gt-input"><span style="font-size:0.68rem;color:var(--gray-mid);">Leave blank to keep current password</span></div>
                <div class="form-group"><label class="gt-label">Confirm Password</label><input type="password" name="password_confirmation" class="gt-input"></div>
                <div class="form-group"><label class="gt-label">Role *</label>
                    <select name="role" class="gt-select" required><option value="staff" {{ old('role',$user->role)=='staff'?'selected':'' }}>Staff</option><option value="admin" {{ old('role',$user->role)=='admin'?'selected':'' }}>Admin</option></select></div>
            </div>
            <div style="display:flex;gap:0.75rem;margin-top:1.5rem;"><button type="submit" class="btn btn-primary">Update User</button><a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-app-layout>