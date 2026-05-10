@php
    $rol = auth()->user()->rol;
    $ui = config("ui.roles.{$rol}", config('ui.roles.particular'));
@endphp

<aside class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-slate-200 bg-white">

    <div class="h-16 flex items-center border-b border-slate-200 px-6 font-serif text-xl text-blue-950">
        <span class="mr-2 text-blue-600">🔧</span> ReparaYa
    </div>

    <nav class="flex-1 flex-col gap-1  p-4 overflow-y-auto">
        @includeFirst([
            "navigation.menus.{$rol}",
            'navigation.menus.default'
        ])
    </nav>

    <div class="p-4 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full text-left text-sm text-gray-400 hover:text-white transition flex items-center gap-2">
                🚪 Cerrar sesión
            </button>
        </form>
    </div>
</aside>