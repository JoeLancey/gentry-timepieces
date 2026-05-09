<x-app-layout header="Consignment Details">
    <x-slot name="actions">
        <a href="{{ route('consignments.edit', $consignment) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('consignments.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot>

    <div class="max-w-2xl">
        <div class="card p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Watch</p>
                    <p class="font-semibold text-gray-900">{{ $consignment->watch->brand }} {{ $consignment->watch->model }}</p>
                    <p class="text-sm text-gray-500">Serial: {{ $consignment->watch->serial_number }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Client</p>
                    <p class="font-semibold text-gray-900">{{ $consignment->client->first_name }} {{ $consignment->client->last_name }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Agreed Price</p>
                    <p class="text-2xl font-bold text-gray-900">₱{{ number_format($consignment->agreed_price, 2) }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Commission Rate</p>
                    <p class="text-xl font-bold text-gray-900">{{ $consignment->commission_rate }}%</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Start Date</p>
                    <p class="text-gray-900">{{ $consignment->start_date->format('M d, Y') }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">End Date</p>
                    <p class="text-gray-900">{{ $consignment->end_date ? $consignment->end_date->format('M d, Y') : '—' }}</p>
                </div>

                <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Status</p>
                    <p><span class="badge badge-{{ $consignment->status }}">{{ ucfirst($consignment->status) }}</span></p>
                </div>

                @if($consignment->notes)
                <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Notes</p>
                    <p class="text-gray-700">{{ $consignment->notes }}</p>
                </div>
                @endif
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 flex items-center gap-3">
                <a href="{{ route('consignments.edit', $consignment) }}" class="btn btn-primary">Edit Consignment</a>
                <form method="POST" action="{{ route('consignments.destroy', $consignment) }}" onsubmit="return confirm('Delete this consignment?');" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
