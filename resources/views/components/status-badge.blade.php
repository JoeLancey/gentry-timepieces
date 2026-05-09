@props(['status'])

@php
$badgeMap = [
    'available' => 'badge-available',
    'sold' => 'badge-sold',
    'consigned' => 'badge-consigned',
    'reserved' => 'badge-reserved',
    'active' => 'badge-active',
    'pending' => 'badge-pending',
    'checking' => 'badge-checking',
    'completed' => 'badge-completed',
    'rejected' => 'badge-rejected',
    'confirmed' => 'badge-confirmed',
    'mint' => 'badge-mint',
    'excellent' => 'badge-excellent',
    'good' => 'badge-good',
    'fair' => 'badge-fair',
    'expired' => 'badge-expired',
    'returned' => 'badge-returned',
    'failed' => 'badge-failed',
];
$badgeClass = $badgeMap[$status] ?? 'badge-gray';
@endphp

<span class="badge {{ $badgeClass }}">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
