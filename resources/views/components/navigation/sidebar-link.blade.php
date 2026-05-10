@props(['route', 'icon' => '', 'active' => null])

@php
    $rol = auth()->user()->rol;
    $ui = config("ui.roles.{$rol}.theme");

    $isActive = $active ?? request()->routeIs($route . '*');

    $baseClasses = 'flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-all duration-200';

    $themeClasses = $isActive
                ? $ui['active']
                : "{$ui['text']} hover:{$ui['accent']} hover:bg-white/5";
@endphp

<a href={{ route($route) }}>
    {{ $attributes->merge(['class' => "{$baseClasses} {$themeClasses}"]) }}

    @if($icon)
        <span class="text-base">
            {{ $icon ?: 'i class="fa-solid fa-' . $ui['icon'] . '"></i>' }}
        </span>
    @endif
    
    <span>{{ $slot }}</span>
</a>