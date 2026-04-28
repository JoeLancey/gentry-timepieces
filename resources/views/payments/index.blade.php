<x-app-layout header="Payments">
    <x-slot:actions><a href="{{ route('payments.create') }}" class="btn btn-primary">+ New Payment</a></x-slot:actions>
    <div class="card" style="padding:0;">
        @if($payments->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr><th>Transaction</th><th>Amount</th><th>Method</th><th>Reference</th><th>Status</th><th>Confirmed</th><th></th></tr></thead>
                <tbody>
                    @foreach($payments as $p)
                    <tr>
                        <td style="font-family:'Playfair Display',serif;">{{ $p->transaction->invoice_number }}</td>
                        <td>₱{{ number_format($p->amount,2) }}</td>
                        <td><span class="badge badge-{{ $p->method }}">{{ str_replace('_',' ',$p->method) }}</span></td>
                        <td style="color:var(--gray-mid);">{{ $p->reference_number ?? '—' }}</td>
                        <td><span class="badge badge-{{ $p->status }}">{{ $p->status }}</span></td>
                        <td style="color:var(--gray-mid);">{{ $p->confirmed_at ? $p->confirmed_at->format('M d, Y') : '—' }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:0.5rem;justify-content:flex-end;">
                                <a href="{{ route('payments.show', $p) }}" class="btn btn-secondary btn-sm">View</a>
                                <a href="{{ route('payments.edit', $p) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('payments.destroy', $p) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">Delete</button></form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:1.25rem 1.5rem;border-top:1px solid var(--gray-pale);">{{ $payments->links() }}</div>
        @else
        <div class="empty-state"><p>No payments recorded yet.</p><a href="{{ route('payments.create') }}" class="btn btn-primary">Record First Payment</a></div>
        @endif
    </div>
</x-app-layout>