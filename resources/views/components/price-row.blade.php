@props(['price', 'label' => 'Price'])

<div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid var(--gray-light);">
    <span style="font-size: 0.875rem; color: var(--gray-mid);">{{ $label }}</span>
    <strong style="font-size: 1rem;">${{ number_format($price, 2) }}</strong>
</div>
