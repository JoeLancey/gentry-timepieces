@props(['value', 'label', 'required' => false])

<div style="margin-bottom: 1rem;">
    <label style="display: flex; align-items: center; cursor: pointer;">
        <input 
            type="checkbox" 
            value="1"
            {{ old($name, $value) ? 'checked' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-checkbox', 'name' => $name]) }}
            style="margin-right: 0.5rem; width: 1rem; height: 1rem; cursor: pointer;"
        />
        <span>{{ $label }}</span>
    </label>
    @error($name)
        <small style="color: #d32f2f; display: block; margin-top: 0.25rem;">{{ $message }}</small>
    @enderror
</div>
