<x-app-layout header="New Payment">
    <x-slot:actions>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="max-w-2xl">
        <x-alert />

        <div class="card p-6">
            <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Transaction *</label>
                        <select name="transaction_id" class="form-select" required>
                            <option value="">Select Transaction</option>
                            @foreach($transactions as $t)
                                <option value="{{ $t->id }}" {{ old('transaction_id')==$t->id?'selected':'' }}>
                                    {{ $t->invoice_number }} - ₱{{ number_format($t->amount,2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('transaction_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Amount (₱) *</label>
                        <input type="number" name="amount" class="form-input" value="{{ old('amount') }}" step="0.01" min="0" required>
                        @error('amount')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Payment Method *</label>
                        <select name="method" class="form-select" required>
                            @foreach(['cash','bank_transfer','check'] as $m)
                                <option value="{{ $m }}" {{ old('method') === $m ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$m)) }}</option>
                            @endforeach
                        </select>
                        @error('method')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select" required>
                            @foreach(['pending','confirmed','failed'] as $s)
                                <option value="{{ $s }}" {{ old('status','pending')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="form-label">Reference Number</label>
                        <input type="text" name="reference_number" class="form-input" value="{{ old('reference_number') }}" placeholder="e.g. Check number, transfer ref">
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="form-label">Proof of Payment</label>
                        <input type="file" name="proof_path" class="form-input" accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Upload payment receipt (optional)</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">Save Payment</button>
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>