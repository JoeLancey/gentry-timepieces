<x-app-layout header="Consignments">
	<x-slot name="actions">
		<a href="{{ route('consignments.create') }}" class="btn btn-primary">+ New Consignment</a>
	</x-slot>

	<x-alert />

	<div class="mb-4">
		<a href="{{ route('consignments.create') }}" class="btn btn-primary">+ New Consignment</a>
	</div>

	<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
		<div class="stat-card">
			<p class="stat-label">Total Consignments</p>
			<p class="stat-value">{{ $consignments->total() }}</p>
		</div>
		<div class="stat-card">
			<p class="stat-label">Expiring Soon</p>
			<p class="stat-value">{{ $expiringSoon }}</p>
		</div>
		<div class="stat-card">
			<p class="stat-label">Active on Page</p>
			<p class="stat-value">{{ $consignments->where('status', 'active')->count() }}</p>
		</div>
	</div>

	<div class="filter-section">
		<form method="GET" class="filter-form">
			<div class="filter-group">
				<label class="form-label">Search</label>
				<input type="text" name="search" class="form-input" placeholder="Client, brand, model..." value="{{ request('search') }}">
			</div>

			<div class="filter-group">
				<label class="form-label">Status</label>
				<select name="status" class="form-select">
					<option value="">All Status</option>
					<option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
					<option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
					<option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
				</select>
			</div>

			<div class="filter-group flex items-end gap-2">
				<button type="submit" class="btn btn-primary">Filter</button>
				<a href="{{ route('consignments.index') }}" class="btn btn-secondary">Clear</a>
			</div>
		</form>
	</div>

	<div class="card overflow-hidden p-0">
		@if($consignments->count())
			<div class="table-container border-0 rounded-none">
				<table class="table">
					<thead>
						<tr>
							<th>Watch</th>
							<th>Client</th>
							<th class="text-right">Agreed Price</th>
							<th class="text-right">Commission</th>
							<th>Status</th>
							<th>Start Date</th>
							<th class="text-right">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($consignments as $c)
						<tr class="group hover:bg-gray-50 transition-colors">
							<td>
								<div class="watch-info">
									<strong>{{ $c->watch?->brand ?? 'N/A' }}</strong>
									<span class="text-gray-500">{{ $c->watch?->model ?? 'Unknown Model' }}</span>
								</div>
							</td>
							<td class="text-gray-700">{{ $c->client?->full_name ?? (($c->client?->first_name ?? '') . ' ' . ($c->client?->last_name ?? '')) }}</td>
							<td class="text-right font-semibold text-gray-900">₱{{ number_format($c->agreed_price, 2) }}</td>
							<td class="text-right text-gray-700">{{ number_format($c->commission_rate, 2) }}%</td>
							<td>
								<span class="badge badge-{{ $c->status }}">{{ ucfirst($c->status) }}</span>
							</td>
							<td class="text-gray-500 text-sm">{{ optional($c->start_date)->format('M d, Y') }}</td>
							<td class="text-right">
								<div class="flex items-center justify-end gap-2">
									<a href="{{ route('consignments.show', $c) }}" class="btn btn-secondary btn-sm">View</a>
									<a href="{{ route('consignments.edit', $c) }}" class="btn btn-ghost text-sm" title="Edit">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
										</svg>
									</a>
									<form method="POST" action="{{ route('consignments.destroy', $c) }}" onsubmit="return confirm('Delete this consignment?')" class="inline">
										@csrf
										@method('DELETE')
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
				{{ $consignments->links() }}
			</div>
		@else
			<div class="empty-state">
				<div class="empty-icon">
					<svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
					</svg>
				</div>
				<h4 class="empty-title">No consignments found</h4>
				<p class="empty-text">Start consigning timepieces with clients.</p>
				<a href="{{ route('consignments.create') }}" class="btn btn-primary">+ New Consignment</a>
			</div>
		@endif
	</div>
</x-app-layout>