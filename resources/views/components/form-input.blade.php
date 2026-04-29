@props(['value', 'label', 'type' => 'text', 'placeholder' => '', 'required' => false, 'disabled' => false, 'class' => ''])

<div class="form-group">
    @if ($label)
        <label class="form-label">
            {{ $label }}
            @if ($required) <span class="text-red-600">*</span> @endif
        </label>
    @endif
    <input 
        type="{{ $type }}" 
        name="{{ $name ?? '' }}"
        value="{{ old($name ?? '', $value) }}" 
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'form-input ' . $class]) }}
    />
    @error($name ?? '')
        <div class="form-error">{{ $message }}</div>
    @enderror
</div>
