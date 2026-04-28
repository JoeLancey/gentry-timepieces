<x-app-layout header="New User">
    <x-slot:actions><a href="{{ route('users.index') }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    <div class="card" style="max-width:500px;">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="form-grid">
                <div class="form-group"><label class="gt-label">Name *</label><input type="text" name="name" class="gt-input" value="{{ old('name') }}" required>@error('name')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Email *</label><input type="email" name="email" class="gt-input" value="{{ old('email') }}" required>@error('email')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Password *</label><input type="password" name="password" class="gt-input" required>@error('password')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Confirm Password *</label><input type="password" name="password_confirmation" class="gt-input" required></div>
                <div class="form-group"><label class="gt-label">Role *</label>
                    <select name="role" class="gt-select" required><option value="staff" {{ old('role')=='staff'?'selected':'' }}>Staff</option><option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option></select></div>
            </div>
            <div style="display:flex;gap:0.75rem;margin-top:1.5rem;"><button type="submit" class="btn btn-primary">Create User</button><a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-app-layout>