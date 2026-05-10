@props(['route', 'active' => null])

@php
    $rol = auth()->user()->rol;
    $ui = config("ui.roles.{$rol}.theme");
    $isActive = $active ?? request()->routeIs($route . '*');

    $baseClasses = 'inline-flex items-center px-4 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out h-full border-b-2';
    
    $themeClasses = $isActive 
        ? $ui['active'] 
        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300';
@endphp

<a href="{{ route($route) }}" {{ $attributes->merge(['class' => "{$baseClasses} {$themeClasses}"]) }}>
    {{ $slot }}
</a>