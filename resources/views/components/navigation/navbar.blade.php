@props(['breadcrumbItems' => []])

@php
    $rol = auth()->user()->rol;
    $ui = config("ui.roles.{$rol}.theme");
@endphp

<nav class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-40">
    <div class="flex items-center gap-4">
        <div class="lg:hidden font-bold text-blue-950 mr-4">
            <span class="{{ $ui['accent'] }}">🔧</span> ReparaYa
        </div>
        
        <x-navigation.breadcrumb :items="$breadcrumbItems" />
    </div>

    <div class="flex items-center gap-4">
        <div class="flex flex-col items-end mr-2">
            <span class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</span>
            <span class="text-[10px] uppercase font-black {{ $ui['accent'] }}">{{ $rol }}</span>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-red-50 hover:text-red-600 transition-colors">
                <span>Cerrar Sesión</span>
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
        </form>
    </div>
</nav>