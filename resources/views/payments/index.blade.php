<x-app-layout header="Payments">
    <x-slot:actions>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">+ Add Payment</a>
    </x-slot:actions>

    <x-alert />

    <div class="card p-5 mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900 tracking-tight">Record a payment</h2>
            <p class="text-sm text-gray-500 mt-1">Create a payment record for an existing transaction.</p>
        </div>
        <a href="{{ route('payments.create') }}" class="btn btn-primary justify-center">
            + Add Payment
        </a>
    </div>

    <div class="card overflow-hidden p-0">
        @if($payments->count())
            <div class="table-container border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="font-serif">Transaction</th>
                            <th class="text-right">Amount</th>
                            <th>Method</th>
                            <th>Reference</th>
                            <th>Status</th>
                            <th>Confirmed</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $p)
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="font-serif text-gray-900">{{ $p->transaction->invoice_number }}</td>
                            <td class="text-right font-semibold text-gray-900">
                                ₱{{ number_format($p->amount, 2) }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $p->method }}">
                                    {{ ucfirst(str_replace('_', ' ', $p->method)) }}
                                </span>
                            </td>
                            <td class="text-gray-500">{{ $p->reference_number ?? '—' }}</td>
                            <td>
                                <span class="badge badge-{{ $p->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                </span>
                            </td>
                            <td class="text-gray-500 text-sm">
                                {{ $p->confirmed_at ? $p->confirmed_at->format('M d, Y') : '—' }}
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('payments.show', $p) }}" class="btn btn-secondary btn-sm">View</a>
                                    <a href="{{ route('payments.edit', $p) }}" class="btn btn-ghost text-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('payments.destroy', $p) }}" onsubmit="return confirm('Delete this payment?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-ghost text-danger text-sm" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $payments->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="empty-title">No payments found</h4>
                <p class="empty-text">Record payments for transactions.</p>
                <a href="{{ route('payments.create') }}" class="btn btn-primary">+ Add Payment</a>
            </div>
        @endif
    </div>
</x-app-layout>