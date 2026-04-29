<x-app-layout header="Edit User">
    <x-slot:actions>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="max-w-md">
        <div class="card p-6">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name',$user->name) }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email',$user->email) }}" required>
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-select" required>
                        @foreach(['staff','admin'] as $r)
                            <option value="{{ $r }}" {{ old('role',$user->role)==$r?'selected':'' }}>{{ ucfirst($r) }}</option>
                        @endforeach
                    </select>
                    @error('role')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-input">
                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password</p>
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-input">
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>