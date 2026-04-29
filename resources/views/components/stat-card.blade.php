@props(['title', 'icon' => null])

<div class="stat-card" style="background: var(--white); border: 1px solid var(--gray-light); border-radius: 8px; padding: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        @if($icon)
            <span style="font-size: 1.5rem;">{{ $icon }}</span>
        @endif
        <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gray-mid); margin: 0;">{{ $title }}</p>
    </div>
    <p class="stat-value" style="font-size: 1.75rem; font-weight: 600; margin: 0;">
        {{ $slot }}
    </p>
</div>
