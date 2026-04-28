@props(['value', 'label', 'type' => 'text', 'placeholder' => '', 'required' => false, 'disabled' => false])

<div style="margin-bottom: 1rem;">
    @if ($label)
        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gray-mid);">
            {{ $label }}
            @if ($required) <span style="color: #d32f2f;">*</span> @endif
        </label>
    @endif
    <input 
        type="{{ $type }}" 
        value="{{ old($name, $value) }}" 
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'form-control', 'name' => $name]) }}
        style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; font-family: inherit; font-size: inherit;"
    />
    @error($name)
        <small style="color: #d32f2f; display: block; margin-top: 0.25rem;">{{ $message }}</small>
    @enderror
</div>
