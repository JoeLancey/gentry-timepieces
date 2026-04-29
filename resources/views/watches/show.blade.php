<x-app-layout header="Watch Detail">
    <x-slot:actions>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('watches.edit', $watch) }}" class="btn btn-primary">Edit</a>
        @endif
        <a href="{{ route('watches.index') }}" class="btn btn-secondary">← Back</a>
    </x-slot:actions>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl">
        <!-- Main Details -->
        <div class="lg:col-span-2">
            <div class="card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight">Watch Information</h2>
                    <span class="badge badge-{{ $watch->status }}">{{ ucfirst($watch->status) }}</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="detail-box">
                        <span class="detail-label">Brand</span>
                        <span class="detail-value">{{ $watch->brand }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Model</span>
                        <span class="detail-value">{{ $watch->model }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Serial Number</span>
                        <span class="detail-value font-mono">{{ $watch->serial_number }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Reference Number</span>
                        <span class="detail-value">{{ $watch->reference_number ?? '—' }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Year Produced</span>
                        <span class="detail-value">{{ $watch->year_produced ?? '—' }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Condition</span>
                        <span class="detail-value">
                            <span class="badge badge-{{ $watch->condition }}">{{ ucfirst($watch->condition) }}</span>
                        </span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Has Box</span>
                        <span class="detail-value">{{ $watch->has_box ? 'Yes' : 'No' }}</span>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Has Papers</span>
                        <span class="detail-value">{{ $watch->has_papers ? 'Yes' : 'No' }}</span>
                    </div>
                </div>

                @if($watch->description)
                <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Description</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $watch->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Pricing Card -->
            <div class="card bg-gray-900 text-white border-0 p-6">
                <p class="text-xs uppercase tracking-wider text-gray-400 mb-3">Asking Price</p>
                <p class="text-3xl font-serif font-bold text-white mb-4">₱{{ number_format($watch->asking_price, 2) }}</p>
                @if(auth()->user()->isAdmin())
                <div class="pt-4 border-t border-gray-700">
                    <p class="text-xs uppercase tracking-wider text-gray-400 mb-1">Cost Price</p>
                    <p class="text-xl font-serif text-gray-400">₱{{ number_format($watch->cost_price, 2) }}</p>
                </div>
                @endif
            </div>

            <!-- Watch Image -->
            @if($watch->image_path)
            <div class="card overflow-hidden p-0">
                <img src="{{ Storage::url($watch->image_path) }}"
                     alt="{{ $watch->brand }} {{ $watch->model }}"
                     class="w-full h-64 object-cover">
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card p-5">
                <h3 class="text-base font-bold text-gray-900 mb-3">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('transactions.create', ['watch_id' => $watch->id]) }}" class="btn btn-primary w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Transaction
                    </a>
                    <a href="{{ route('appraisals.create', ['watch_id' => $watch->id]) }}" class="btn btn-secondary w-full justify-center">
                        Request Appraisal
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>