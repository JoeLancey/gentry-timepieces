<x-app-layout header="New Client">
    <x-slot:actions><a href="{{ route('clients.index') }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    <div class="card" style="max-width:700px;">
        <form method="POST" action="{{ route('clients.store') }}">
            @csrf
            <div class="form-grid form-grid-2">
                <div class="form-group"><label class="gt-label">First Name *</label><input type="text" name="first_name" class="gt-input" value="{{ old('first_name') }}" required>@error('first_name')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Last Name *</label><input type="text" name="last_name" class="gt-input" value="{{ old('last_name') }}" required>@error('last_name')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Phone *</label><input type="text" name="phone" class="gt-input" value="{{ old('phone') }}" required>@error('phone')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Email</label><input type="email" name="email" class="gt-input" value="{{ old('email') }}"></div>
            </div>
            <div class="form-group" style="margin-top:1.25rem;"><label class="gt-label">Address</label><textarea name="address" class="gt-textarea">{{ old('address') }}</textarea></div>
            <div class="form-group" style="margin-top:1.25rem;margin-bottom:1.5rem;"><label class="gt-label">Notes</label><textarea name="notes" class="gt-textarea">{{ old('notes') }}</textarea></div>
            <div style="display:flex;gap:0.75rem;"><button type="submit" class="btn btn-primary">Save Client</button><a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-app-layout>