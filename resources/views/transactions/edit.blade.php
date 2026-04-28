<x-app-layout header="Edit Transaction">
    <x-slot:actions><a href="{{ route('transactions.show', $transaction) }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    <div class="card" style="max-width:700px;">
        <form method="POST" action="{{ route('transactions.update', $transaction) }}">
            @csrf @method('PUT')
            <div class="form-grid form-grid-2">
                <div class="form-group"><label class="gt-label">Watch *</label>
                    <select name="watch_id" class="gt-select" required><option value="">Select Watch</option>@foreach($watches as $w)<option value="{{ $w->id }}" {{ old('watch_id',$transaction->watch_id)==$w->id?'selected':'' }}>{{ $w->brand }} {{ $w->model }} — {{ $w->serial_number }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">Client *</label>
                    <select name="client_id" class="gt-select" required><option value="">Select Client</option>@foreach($clients as $c)<option value="{{ $c->id }}" {{ old('client_id',$transaction->client_id)==$c->id?'selected':'' }}>{{ $c->first_name }} {{ $c->last_name }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">Type *</label>
                    <select name="type" class="gt-select" required>@foreach(['sale','trade_in'] as $t)<option value="{{ $t }}" {{ old('type',$transaction->type)==$t?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$t)) }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">Amount (₱) *</label><input type="number" name="amount" class="gt-input" value="{{ old('amount',$transaction->amount) }}" step="0.01" required></div>
            </div>
            <div class="form-group" style="margin-top:1.25rem;margin-bottom:1.5rem;"><label class="gt-label">Notes</label><textarea name="notes" class="gt-textarea">{{ old('notes',$transaction->notes) }}</textarea></div>
            <div style="display:flex;gap:0.75rem;"><button type="submit" class="btn btn-primary">Update Transaction</button><a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-app-layout>