@props(['options', 'value', 'label', 'placeholder' => 'Select...', 'required' => false, 'disabled' => false])

<div style="margin-bottom: 1rem;">
    @if ($label)
        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gray-mid);">
            {{ $label }}
            @if ($required) <span style="color: #d32f2f;">*</span> @endif
        </label>
    @endif
    <select 
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'form-select', 'name' => $name]) }}
        style="width: 100%; padding: 0.625rem; border: 1px solid var(--gray-light); border-radius: 3px; font-family: inherit; font-size: inherit;"
    >
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @error($name)
        <small style="color: #d32f2f; display: block; margin-top: 0.25rem;">{{ $message }}</small>
    @enderror
</div>
