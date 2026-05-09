<x-app-layout header="Appraisal Details">
    <x-slot:actions>
        <a href="{{ route('appraisals.edit', $appraisal) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('appraisals.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="max-w-2xl">
        <div class="card p-6">
            <div class="mb-6 p-4 rounded-lg border border-gray-200 bg-gray-50">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Workflow Status</p>
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="badge badge-{{ $appraisal->status }}">{{ ucfirst($appraisal->status) }}</span>
                    <span class="text-sm text-gray-600">
                        @if($appraisal->status === 'pending')
                            Waiting for staff review.
                        @elseif($appraisal->status === 'checking')
                            Staff is inspecting the watch.
                        @elseif($appraisal->status === 'completed')
                            The appraisal has been finalized.
                        @else
                            The client declined the deal.
                        @endif
                    </span>
                </div>
            </div>

            <div class="mb-6 p-4 rounded-lg border border-gray-200 bg-white">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Workflow Timeline</p>
                <div class="space-y-4">
                    @foreach($timeline->sortBy('created_at')->values() as $entry)
                        <div class="flex items-start gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-gray-900"></span>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $entry->action)) }}</p>
                                <p class="text-sm text-gray-600">{{ $entry->description }}</p>
                                <p class="text-xs text-gray-500">{{ $entry->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

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
                    <p class="text-2xl font-bold text-gray-900">
                        @if($appraisal->status === 'completed')
                            ₱{{ number_format($appraisal->appraised_value, 2) }}
                        @else
                            Awaiting review
                        @endif
                    </p>
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

                @if($appraisal->review_notes)
                <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Send Back Note</p>
                    <p class="text-gray-700">{{ $appraisal->review_notes }}</p>
                </div>
                @endif

                @if($appraisal->status === 'completed')
                <div class="md:col-span-2 p-4 rounded-lg border border-green-200 bg-green-50">
                    <p class="text-xs font-semibold uppercase tracking-wider text-green-700 mb-1">Inventory Handoff</p>
                    <p class="text-sm text-green-900">The watch has moved into inventory as available.</p>
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                        <div><span class="text-green-700">Inventory status:</span> <strong>{{ ucfirst($appraisal->watch->status) }}</strong></div>
                        <div><span class="text-green-700">Final value:</span> <strong>₱{{ number_format($appraisal->appraised_value, 2) }}</strong></div>
                        <div><span class="text-green-700">Condition:</span> <strong>{{ ucfirst($appraisal->watch->condition) }}</strong></div>
                    </div>
                </div>
                @endif

                @if($appraisal->condition_notes)
                <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border-l-4 border-l-gray-900">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Condition Notes</p>
                    <p class="text-gray-700">{{ $appraisal->condition_notes }}</p>
                </div>
                @endif
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 flex items-center gap-3 flex-wrap">
                <a href="{{ route('appraisals.edit', $appraisal) }}" class="btn btn-primary">Edit Appraisal</a>

                @if($appraisal->status === 'pending')
                    <form method="POST" action="{{ route('appraisals.checking', $appraisal) }}" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Mark Checking</button>
                    </form>
                @elseif($appraisal->status === 'checking')
                    <a href="{{ route('appraisals.edit', $appraisal) }}" class="btn btn-secondary">Finalize Review</a>
                    <form method="POST" action="{{ route('appraisals.reject', $appraisal) }}" onsubmit="return confirm('Reject this appraisal?');" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                @elseif($appraisal->status === 'completed')
                    <a href="{{ route('watches.show', $appraisal->watch) }}" class="btn btn-secondary">Open Inventory Record</a>
                @elseif($appraisal->status === 'rejected')
                    <span class="text-sm text-gray-500">This appraisal was rejected.</span>
                @endif

                <form method="POST" action="{{ route('appraisals.destroy', $appraisal) }}" onsubmit="return confirm('Delete this appraisal?');" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
