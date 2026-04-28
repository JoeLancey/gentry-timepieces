    <x-app-layout header="New Payment">
    <x-slot:actions><a href="{{ route('payments.index') }}" class="btn btn-secondary">← Back</a></x-slot:actions>
    <div class="card" style="max-width:700px;">
        <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-grid form-grid-2">
                <div class="form-group"><label class="gt-label">Transaction *</label>
                    <select name="transaction_id" class="gt-select" required><option value="">Select Transaction</option>@foreach($transactions as $t)<option value="{{ $t->id }}" {{ old('transaction_id')==$t->id?'selected':'' }}>{{ $t->invoice_number }} — {{ $t->client->first_name }} {{ $t->client->last_name }}</option>@endforeach</select>
                    @error('transaction_id')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Amount (₱) *</label><input type="number" name="amount" class="gt-input" value="{{ old('amount') }}" step="0.01" min="0" required>@error('amount')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Method *</label>
                    <select name="method" class="gt-select" required><option value="">Select Method</option>@foreach(['cash','bank_transfer','check'] as $m)<option value="{{ $m }}" {{ old('method')==$m?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$m)) }}</option>@endforeach</select>
                    @error('method')<span class="form-error">{{ $message }}</span>@enderror</div>
                <div class="form-group"><label class="gt-label">Reference Number</label><input type="text" name="reference_number" class="gt-input" value="{{ old('reference_number') }}"></div>
                <div class="form-group"><label class="gt-label">Status *</label>
                    <select name="status" class="gt-select" required>@foreach(['pending','confirmed','failed'] as $s)<option value="{{ $s }}" {{ old('status','pending')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
                <div class="form-group"><label class="gt-label">Confirmed At</label><input type="datetime-local" name="confirmed_at" class="gt-input" value="{{ old('confirmed_at') }}"></div>
                <div class="form-group" style="grid-column:span 2;"><label class="gt-label">Proof of Payment</label><input type="file" name="proof" class="gt-input" accept="image/*"></div>
            </div>
            <div style="display:flex;gap:0.75rem;margin-top:1.5rem;"><button type="submit" class="btn btn-primary">Save Payment</button><a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-app-layout>