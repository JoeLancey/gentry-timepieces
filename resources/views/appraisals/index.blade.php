<x-app-layout header="Appraisals">
    <x-slot:actions><a href="{{ route('appraisals.create') }}" class="btn btn-primary">+ New Appraisal</a></x-slot:actions>
    <div class="card" style="padding:0;">
        @if($appraisals->count())
        <div class="table-wrapper">
            <table class="gt-table">
                <thead><tr><th>Watch</th><th>Client</th><th>Appraiser</th><th>Value</th><th>Status</th><th>Date</th><th></th></tr></thead>
                <tbody>
                    @foreach($appraisals as $a)
                    <tr>
                        <td><strong>{{ $a->watch->brand }}</strong><br><span style="color:var(--gray-mid);font-size:0.78rem;">{{ $a->watch->model }}</span></td>
                        <td>{{ $a->client->first_name }} {{ $a->client->last_name }}</td>
                        <td>{{ $a->appraiser->name }}</td>
                        <td>₱{{ number_format($a->appraised_value,2) }}</td>
                        <td><span class="badge badge-{{ $a->status }}">{{ $a->status }}</span></td>
                        <td style="color:var(--gray-mid);">{{ $a->created_at->format('M d, Y') }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:0.5rem;justify-content:flex-end;">
                                <a href="{{ route('appraisals.show', $a) }}" class="btn btn-secondary btn-sm">View</a>
                                <a href="{{ route('appraisals.edit', $a) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('appraisals.destroy', $a) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">Delete</button></form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:1.25rem 1.5rem;border-top:1px solid var(--gray-pale);">{{ $appraisals->links() }}</div>
        @else
        <div class="empty-state"><p>No appraisals recorded yet.</p><a href="{{ route('appraisals.create') }}" class="btn btn-primary">Create First Appraisal</a></div>
        @endif
    </div>
</x-app-layout>