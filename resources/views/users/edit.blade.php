<x-app-layout header="Edit User">
    <x-slot:actions>
        <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">View Profile</a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="card">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h2>
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="divider"></div>

                    <div class="form-group">
                        <label class="form-label">Role *</label>
                        <select name="role" class="form-select" required>
                            <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>
                                Staff (Limited Access)
                            </option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                Admin (Full Access)
                            </option>
                        </select>
                        @error('role')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="divider"></div>

                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Change Password (Optional)</h3>
                    
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-input" placeholder="Leave blank to keep current">
                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm new password">
                    </div>

                    <div class="flex items-center gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="space-y-4">
            <div class="card">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">User Details</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Account Status</p>
                        @if($user->isOnline())
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                                <span class="text-sm font-semibold text-green-700">Online</span>
                            </div>
                        @else
                            <p class="text-sm text-gray-600 mt-1">Offline</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Current Role</p>
                        <span class="badge badge-{{ $user->role }} mt-1">{{ ucfirst($user->role) }}</span>
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
                        <p class="text-xs text-gray-500 uppercase font-semibold">Joined</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            @if(auth()->id() !== $user->id)
            <div class="card border-red-200 bg-red-50">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Danger Zone</h3>
                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger w-full">Delete User Account</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>