@props(['value', 'label', 'placeholder' => '', 'required' => false, 'rows' => 4, 'class' => ''])

<div class="form-group">
    @if ($label)
        <label class="form-label">
            {{ $label }}
            @if ($required) <span class="text-red-600">*</span> @endif
        </label>
    @endif
    <textarea 
        placeholder="{{ $placeholder }}"
        rows="{{ $rows }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-textarea ' . $class]) }}
    >{{ old($name ?? '', $value) }}</textarea>
    @error($attributes->get('name') ?? '')
        <div class="form-error">{{ $message }}</div>
    @enderror
</div>
