@props(['route', 'icon', 'label'])

@php
    $active = request()->routeIs($route) ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white';
@endphp

<a href="{{ route($route) }}"
   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition {{ $active }}">
    <span>{{ $icon }}</span>
    <span>{{ $label }}</span>
</a>