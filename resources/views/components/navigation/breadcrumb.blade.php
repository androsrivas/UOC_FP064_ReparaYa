@props(['items' => []])

@php
    $rol = auth()->user()->rol;
    $ui = config("ui.roles.{$rol}.theme");

    $homeRoute = match($rol) {
        'tecnico' => 'tecnico.agenda',
        'particular' => 'cliente.incidencias',
        'gestora' => 'gestora.incidencias',
        default => 'dashboard',
    };
@endphp

<nav class="flex text-gray-500 text-sm" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route($homeRoute) }}" class="hover:{{ $ui['accent'] }} inline-flex items-center transition-colors">
                <i class="fa-solid fa-house text-xs mr-2"></i>
                <span class="hidden sm:inline">Inicio</span>
            </a>
        </li>

        @foreach($items as $label => $link)
            <li class="flex items-center">
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 mx-1 md:mx-2"></i>
                
                @if(!$loop->last && $link)
                    <a href="{{ $link }}" class="hover:{{ $ui['accent'] }} font-medium transition-colors whitespace-nowrap">
                        {{ $label }}
                    </a>
                @else
                    <span class="text-slate-900 font-bold whitespace-nowrap" aria-current="page">
                        {{ $label }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>