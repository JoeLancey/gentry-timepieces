<x-app-layout header="Edit Client">
    <x-slot:actions><a href="{{ route('clients.show', $client) }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    <div class="card" style="max-width:700px;">
        <form method="POST" action="{{ route('clients.update', $client) }}">
            @csrf @method('PUT')
            <div class="form-grid form-grid-2">
                <div class="form-group"><label class="gt-label">First Name *</label><input type="text" name="first_name" class="gt-input" value="{{ old('first_name',$client->first_name) }}" required></div>
                <div class="form-group"><label class="gt-label">Last Name *</label><input type="text" name="last_name" class="gt-input" value="{{ old('last_name',$client->last_name) }}" required></div>
                <div class="form-group"><label class="gt-label">Phone *</label><input type="text" name="phone" class="gt-input" value="{{ old('phone',$client->phone) }}" required></div>
                <div class="form-group"><label class="gt-label">Email</label><input type="email" name="email" class="gt-input" value="{{ old('email',$client->email) }}"></div>
            </div>
            <div class="form-group" style="margin-top:1.25rem;"><label class="gt-label">Address</label><textarea name="address" class="gt-textarea">{{ old('address',$client->address) }}</textarea></div>
            <div class="form-group" style="margin-top:1.25rem;margin-bottom:1.5rem;"><label class="gt-label">Notes</label><textarea name="notes" class="gt-textarea">{{ old('notes',$client->notes) }}</textarea></div>
            <div style="display:flex;gap:0.75rem;"><button type="submit" class="btn btn-primary">Update Client</button><a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-app-layout>