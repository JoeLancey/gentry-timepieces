<x-app-layout header="Create New User">
    <x-slot:actions>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="max-w-2xl">
        <x-alert />

        <div class="card p-6">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="form-grid form-grid-2">
                    <div class="form-group md:col-span-2">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="e.g., John Smith" required>
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="user@example.com" required>
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password *</label>
                        <input type="password" name="password" class="form-input" placeholder="Min 8 characters" required>
                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Re-enter password" required>
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="form-label">Role *</label>
                        <select name="role" class="form-select" required>
                            <option value="staff" {{ old('role', 'staff') === 'staff' ? 'selected' : '' }}>Staff (Limited Access)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                        </select>
                        @error('role')<div class="form-error">{{ $message }}</div>@enderror
                        <p class="text-xs text-gray-500 mt-1">Default is Staff. You can promote this account later.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 mt-6 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">Create User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>