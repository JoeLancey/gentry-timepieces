<x-app-layout header="Transactions">
    <x-slot:actions><a href="{{ route('transactions.create') }}" class="btn btn-primary">+ New Transaction</a></x-slot:actions>
    <div class="card" style="padding:0;">
        @if($transactions->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr><th>Invoice</th><th>Watch</th><th>Client</th><th>Staff</th><th>Type</th><th>Amount</th><th>Date</th><th></th></tr></thead>
                <tbody>
                    @foreach($transactions as $t)
                    <tr>
                        <td style="font-family:'Playfair Display',serif;">{{ $t->invoice_number }}</td>
                        <td><strong>{{ $t->watch->brand }}</strong><br><span style="color:var(--gray-mid);font-size:0.78rem;">{{ $t->watch->model }}</span></td>
                        <td>{{ $t->client->first_name }} {{ $t->client->last_name }}</td>
                        <td>{{ $t->staff->name }}</td>
                        <td><span class="badge badge-{{ $t->type }}">{{ $t->type }}</span></td>
                        <td>₱{{ number_format($t->amount,2) }}</td>
                        <td style="color:var(--gray-mid);">{{ $t->created_at->format('M d, Y') }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:0.5rem;justify-content:flex-end;">
                                <a href="{{ route('transactions.show', $t) }}" class="btn btn-secondary btn-sm">View</a>
                                <a href="{{ route('transactions.edit', $t) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('transactions.destroy', $t) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">Delete</button></form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:1.25rem 1.5rem;border-top:1px solid var(--gray-pale);">{{ $transactions->links() }}</div>
        @else
        <div class="empty-state"><p>No transactions recorded yet.</p><a href="{{ route('transactions.create') }}" class="btn btn-primary">Record First Transaction</a></div>
        @endif
    </div>
</x-app-layout>