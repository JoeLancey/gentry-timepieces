<x-app-layout header="Edit Client">
    <x-slot:actions>
        <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="max-w-2xl">
        <div class="card p-6">
            <form method="POST" action="{{ route('clients.update', $client) }}">
                @csrf @method('PUT')

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label">First Name *</label>
                        <input type="text" name="first_name" class="form-input" value="{{ old('first_name',$client->first_name) }}" required>
                        @error('first_name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Last Name *</label>
                        <input type="text" name="last_name" class="form-input" value="{{ old('last_name',$client->last_name) }}" required>
                        @error('last_name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone',$client->phone) }}" required>
                        @error('phone')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email',$client->email) }}">
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group mt-6">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-textarea">{{ old('address',$client->address) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-textarea">{{ old('notes',$client->notes) }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">Update Client</button>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>