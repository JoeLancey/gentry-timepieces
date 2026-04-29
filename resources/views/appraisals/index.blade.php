<x-app-layout header="Appraisals">
    <x-slot:actions>
        <a href="{{ route('appraisals.create') }}" class="btn btn-primary">+ New Appraisal</a>
    </x-slot:actions>

    <x-alert />

    <div class="card overflow-hidden p-0">
        @if($appraisals->count())
            <div class="table-container border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Watch</th>
                            <th>Client</th>
                            <th>Appraiser</th>
                            <th class="text-right">Value</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appraisals as $a)
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td>
                                <div class="watch-info">
                                    <strong>{{ $a->watch->brand }}</strong>
                                    <span class="text-gray-500">{{ $a->watch->model }}</span>
                                </div>
                            </td>
                            <td class="text-gray-700">{{ $a->client->first_name }} {{ $a->client->last_name }}</td>
                            <td class="text-gray-600">{{ $a->appraiser->name }}</td>
                            <td class="text-right font-semibold text-gray-900">
                                ₱{{ number_format($a->appraised_value, 2) }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $a->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $a->status)) }}
                                </span>
                            </td>
                            <td class="text-gray-500 text-sm">{{ $a->created_at->format('M d, Y') }}</td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('appraisals.show', $a) }}" class="btn btn-secondary btn-sm">View</a>
                                    <a href="{{ route('appraisals.edit', $a) }}" class="btn btn-ghost text-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('appraisals.destroy', $a) }}" onsubmit="return confirm('Delete this appraisal?')" class="inline">
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
                {{ $appraisals->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h4 class="empty-title">No appraisals found</h4>
                <p class="empty-text">Create appraisals to evaluate timepiece values.</p>
                <a href="{{ route('appraisals.create') }}" class="btn btn-primary">+ New Appraisal</a>
            </div>
        @endif
    </div>
</x-app-layout>