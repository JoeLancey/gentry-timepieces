@props(['value', 'label', 'required' => false])

<div class="flex items-center gap-2 mb-4">
    <input 
        type="checkbox" 
        {{ old($name ?? '', $value) ? 'checked' : '' }}
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-4 h-4 accent-gray-900']) }}
    />
    <label class="text-sm font-medium text-gray-700 cursor-pointer">
        {{ $label }}
    </label>
</div>
