@props(['label', 'name', 'type' => 'text', 'placeholder' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-text mb-1 font-body">
        {{ $label }}
    </label>
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-border rounded-custom bg-surface text-text focus:border-accent focus:ring-1 focus:ring-accent transition-custom outline-none placeholder:text-muted/50']) }}
    >
    @error($name)
        <p class="mt-1 text-xs text-error font-medium">{{ $message }}</p>
    @enderror
</div>