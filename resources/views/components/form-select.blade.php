@props(['options', 'value', 'label' => null, 'placeholder' => 'Select...', 'required' => false, 'disabled' => false, 'class' => ''])

<div class="form-group">
    @if ($label)
        <label class="form-label">
            {{ $label }}
            @if ($required) <span class="text-red-600">*</span> @endif
        </label>
    @endif
    <select 
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'form-select ' . $class, 'name' => $attributes->get('name')]) }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ old($attributes->get('name'), $value) == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @error($attributes->get('name'))
        <div class="form-error">{{ $message }}</div>
    @enderror
</div>
