<x-app-layout header="Appraisal Details">
    <x-slot:actions>
        <a href="{{ route('appraisals.edit', $appraisal) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('appraisals.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="max-w-2xl">
        <div class="card p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Watch</p>
                    <p class="font-semibold text-gray-900">{{ $appraisal->watch->brand }} {{ $appraisal->watch->model }}</p>
                    <p class="text-sm text-gray-500">Serial: {{ $appraisal->watch->serial_number }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Client</p>
                    <p class="font-semibold text-gray-900">{{ $appraisal->client->first_name }} {{ $appraisal->client->last_name }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Appraiser</p>
                    <p class="font-semibold text-gray-900">{{ $appraisal->appraiser->name }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Appraised Value</p>
                    <p class="text-2xl font-bold text-gray-900">₱{{ number_format($appraisal->appraised_value, 2) }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Status</p>
                    <p><span class="badge badge-{{ $appraisal->status }}">{{ ucfirst($appraisal->status) }}</span></p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Date</p>
                    <p class="text-gray-900">{{ $appraisal->created_at->format('M d, Y') }}</p>
                </div>

                <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Details</p>
                    <div class="flex gap-4 text-sm">
                        <span>Has Box: <strong>{{ $appraisal->has_box ? 'Yes' : 'No' }}</strong></span>
                        <span>Has Papers: <strong>{{ $appraisal->has_papers ? 'Yes' : 'No' }}</strong></span>
                    </div>
                </div>

                @if($appraisal->condition_notes)
                <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Condition Notes</p>
                    <p class="text-gray-700">{{ $appraisal->condition_notes }}</p>
                </div>
                @endif
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 flex items-center gap-3">
                <a href="{{ route('appraisals.edit', $appraisal) }}" class="btn btn-primary">Edit Appraisal</a>
                <form method="POST" action="{{ route('appraisals.destroy', $appraisal) }}" onsubmit="return confirm('Delete this appraisal?');" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
