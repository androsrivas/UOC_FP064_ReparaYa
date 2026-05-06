@props(['active' => false, 'icon' => ''])

@php
    $classes = $active
                ? 'flex items-center gap-3 rounded-lg bg-blue-50 px-4 py-2.5 text-sm font-medium text-blue-700 transition-colors'
                : 'flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 hover:text-blue-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <span class="text-base">{{ $icon }}</span>
    @endif
    <span>{{ $slot }}</span>
</a>