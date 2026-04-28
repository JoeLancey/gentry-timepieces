<x-app-layout header="Consignments">
    <x-slot:actions><a href="{{ route('consignments.create') }}" class="btn btn-primary">+ New Consignment</a></x-slot:actions>
    <div class="card" style="padding:0;">
        @if($consignments->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr><th>Watch</th><th>Client</th><th>Agreed Price</th><th>Commission</th><th>Status</th><th>Start Date</th><th></th></tr></thead>
                <tbody>
                    @foreach($consignments as $c)
                    <tr>
                        <td><strong>{{ $c->watch->brand }}</strong><br><span style="color:var(--gray-mid);font-size:0.78rem;">{{ $c->watch->model }}</span></td>
                        <td>{{ $c->client->first_name }} {{ $c->client->last_name }}</td>
                        <td>₱{{ number_format($c->agreed_price,2) }}</td>
                        <td>{{ $c->commission_rate }}%</td>
                        <td><span class="badge badge-{{ $c->status }}">{{ $c->status }}</span></td>
                        <td style="color:var(--gray-mid);">{{ $c->start_date->format('M d, Y') }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:0.5rem;justify-content:flex-end;">
                                <a href="{{ route('consignments.show', $c) }}" class="btn btn-secondary btn-sm">View</a>
                                <a href="{{ route('consignments.edit', $c) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('consignments.destroy', $c) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">Delete</button></form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:1.25rem 1.5rem;border-top:1px solid var(--gray-pale);">{{ $consignments->links() }}</div>
        @else
        <div class="empty-state"><p>No consignments recorded yet.</p><a href="{{ route('consignments.create') }}" class="btn btn-primary">Create First Consignment</a></div>
        @endif
    </div>
</x-app-layout> 