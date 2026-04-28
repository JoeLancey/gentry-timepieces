@props(['status', 'class' => ''])

@php
$badges = [
    'available' => 'bg-green-500 text-white',
    'sold' => 'bg-red-500 text-white',
    'consigned' => 'bg-blue-500 text-white',
    'reserved' => 'bg-yellow-500 text-black',
    'active' => 'bg-green-500 text-white',
    'expired' => 'bg-gray-500 text-white',
    'pending' => 'bg-yellow-500 text-black',
    'completed' => 'bg-green-500 text-white',
    'rejected' => 'bg-red-500 text-white',
    'confirmed' => 'bg-green-500 text-white',
];
$badgeClass = $badges[$status] ?? 'bg-gray-400 text-white';
@endphp

<span class="{{ $badgeClass }} {{ $class }}" style="padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; display: inline-block;">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
