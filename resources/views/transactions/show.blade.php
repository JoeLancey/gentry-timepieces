<x-app-layout header="Transaction Details">
    <x-slot name="actions">
        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="card p-6">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div>
                        <h2 class="text-2xl font-mono font-bold text-gray-900 tracking-tight">{{ $transaction->invoice_number }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $transaction->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>
                    <span class="badge badge-{{ $transaction->type }}">
                        {{ ucfirst(str_replace('_', ' ', $transaction->type)) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Watch</p>
                        <p class="font-semibold text-gray-900">{{ $transaction->watch->brand }} {{ $transaction->watch->model }}</p>
                        <p class="text-sm text-gray-500 mt-0.5">Serial: {{ $transaction->watch->serial_number ?? '—' }}</p>
                    </div>

                    @if($transaction->type === 'buy')
                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Purchase Type</p>
                        <p class="font-semibold text-gray-900">Buy</p>
                        <p class="text-sm text-gray-500 mt-0.5">Watch bought into inventory</p>
                    </div>
                    @elseif($transaction->type === 'trade_in')
                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Trade-in Watch</p>
                        <p class="font-semibold text-gray-900">
                            {{ $transaction->tradeInWatch?->brand }} {{ $transaction->tradeInWatch?->model }}
                        </p>
                        <p class="text-sm text-gray-500 mt-0.5">
                            Cash from: {{ ucfirst($transaction->trade_in_cash_from ?? '—') }}
                        </p>
                    </div>
                    @endif

                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Client</p>
                        <p class="font-semibold text-gray-900">{{ $transaction->client->first_name }} {{ $transaction->client->last_name }}</p>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $transaction->client->email ?? '—' }}</p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Staff</p>
                        <p class="font-semibold text-gray-900">{{ $transaction->staff->name }}</p>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $transaction->staff->email }}</p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Amount</p>
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($transaction->amount, 2) }}</p>
                        <p class="text-sm text-gray-500 mt-0.5">Transaction value</p>
                    </div>
                </div>

                @if($transaction->notes)
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg border-l-4 border-l-gray-900 mb-6">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Notes</p>
                    <p class="text-gray-700 leading-relaxed">{{ $transaction->notes }}</p>
                </div>
                @endif

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-primary">Edit Transaction</a>
                    <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" onsubmit="return confirm('Are you sure you want to delete this transaction?');" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="card p-5">
                <h3 class="text-base font-bold text-gray-900 mb-4">Transaction Summary</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Invoice Number</span>
                        <strong class="font-mono text-gray-900">{{ $transaction->invoice_number }}</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Amount</span>
                        <strong class="text-gray-900">₱{{ number_format($transaction->amount, 2) }}</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Type</span>
                        <strong class="text-gray-800 capitalize">{{ str_replace('_', ' ', $transaction->type) }}</strong>
                    </div>
                    @if($transaction->type === 'trade_in')
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Trade-in Cash</span>
                        <strong class="text-gray-900">{{ ucfirst($transaction->trade_in_cash_from ?? '—') }}</strong>
                    </div>
                    @endif
                    <div class="border-t border-gray-200 my-2"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Recorded On</span>
                        <strong class="text-gray-900">{{ $transaction->created_at->format('M d, Y') }}</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Last Updated</span>
                        <strong class="text-gray-900">{{ $transaction->updated_at->format('M d, Y') }}</strong>
                    </div>
                </div>
            </div>

            <div class="card p-5">
                <h3 class="text-base font-bold text-gray-900 mb-4">Watch Info</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Brand</span>
                        <strong class="text-gray-900">{{ $transaction->watch->brand }}</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Model</span>
                        <strong class="text-gray-900">{{ $transaction->watch->model }}</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Asking Price</span>
                        <strong class="text-gray-900">₱{{ number_format($transaction->watch->asking_price, 2) }}</strong>
                    </div>
                    @if($transaction->type === 'trade_in' && $transaction->tradeInWatch)
                    <div class="border-t border-gray-200 my-2"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Trade-in Watch</span>
                        <strong class="text-gray-900">{{ $transaction->tradeInWatch->brand }} {{ $transaction->tradeInWatch->model }}</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Trade-in Value</span>
                        <strong class="text-gray-900">₱{{ number_format($transaction->trade_in_appraisal_value ?? 0, 2) }}</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>