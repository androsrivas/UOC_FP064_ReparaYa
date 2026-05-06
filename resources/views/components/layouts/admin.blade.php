<x-layouts.base :title="$title ?? 'Panel de Control'">
    <div class="flex min-h-screen bg-slate-50 font-sans">
        
        <aside class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-slate-200 bg-white">
            <div class="flex h-16 items-center border-b border-slate-200 px-6 font-serif text-xl text-blue-950">
                <span class="mr-2 text-blue-600">🔧</span> ReparaYa
            </div>

            <nav class="flex flex-1 flex-col gap-2 p-4">
                <x-navigation.sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="📊">
                    Visión General
                </x-navigation.sidebar-link>

                @if(auth()->user()->rol === 'admin')
                    <x-navigation.sidebar-link :href="route('incidencias.index')" :active="request()->routeIs('incidencias.*')" icon="📋">
                        Incidencias
                    </x-navigation.sidebar-link>
                    {{-- <x-navigation.sidebar-link :href="" :active="request()->routeIs('tecnicos.*')" icon="👨‍🔧">
                        Técnicos
                    </x-navigation.sidebar-link>
                    <x-navigation.sidebar-link :href="route('gestoras.index')" :active="request()->routeIs('gestoras.*')" icon="🏢">
                        Gestoras
                    </x-navigation.sidebar-link> --}}
                @endif
            </nav>

            <div class="border-t border-slate-200 p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <div class="ml-64 flex flex-1 flex-col">
            <x-navigation.navbar :breadcrumbItems="$breadcrumbItems ?? []" />

            <main class="p-8 lg:p-10">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layouts.base>