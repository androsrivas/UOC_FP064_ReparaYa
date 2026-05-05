<x-layouts.base>
     <x-slot name="title">Panel de Administración — ReparaYa</x-slot>

    <div class="flex min-h-screen bg-slate-50 font-sans">
        
        <aside class="fixed inset-y-0 left-0 z-50 flex w-65 flex-col border-r border-slate-200 bg-white">
            <div class="flex h-16 items-center border-b border-slate-200 px-6">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 font-serif text-xl text-blue-950 no-underline">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-sm text-white">
                        🔧
                    </div>
                    ReparaYa
                </a>
            </div>

            <x-navigation.sidebar />
            
            <nav class="flex flex-1 flex-col gap-2 p-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg bg-blue-50 px-4 py-2.5 text-sm font-medium text-blue-700 transition-colors">
                    📊 Visión General
                </a>
                <a href="{{ route('incidencias.index') }}" class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-700 transition-colors">
                    📋 Incidencias
                </a>
                <a href="{{ route('calendario') }}" class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-700 transition-colors">
                    📅 Calendario Técnicos
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-700 transition-colors">
                    👨‍🔧 Técnicos
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-700 transition-colors">
                    🏢 Gestoras
                </a>
            </nav>

            <div class="border-t border-slate-200 p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-left text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <main class="ml-65 flex-1 p-8 lg:p-10">
            <header class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <h1 class="mb-1 font-serif text-3xl text-blue-950">Hola, {{ auth()->user()->name ?? 'Administrador' }}</h1>
                    <p class="text-sm text-slate-500">Aquí tienes el resumen de la actividad de hoy.</p>
                </div>
                <div>
                    <a href="#" class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-800">
                        + Nueva Incidencia
                    </a>
                </div>
            </header>

            <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="mb-2 text-sm text-slate-500">Incidencias de hoy</div>
                    <div class="font-serif text-3xl leading-none text-blue-950">{{ $incidencias_hoy }}</div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="mb-2 text-sm text-slate-500">Pendientes de Asignar</div>
                    <div class="font-serif text-3xl leading-none text-orange-600">{{ $pendientes_asignar }}</div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="mb-2 text-sm text-slate-500">Técnicos Activos</div>
                    <div class="font-serif text-3xl leading-none text-blue-950">{{ $tecnicos_activos }}</div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="mb-2 text-sm text-slate-500">Resueltas este mes</div>
                    <div class="font-serif text-3xl leading-none text-teal-600">{{ $resueltas_mes }}</div>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                    <h2 class="font-serif text-xl text-blue-950">Últimas incidencias reportadas</h2>
                    <a href="{{ route('incidencias.index') }}" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 transition-colors hover:border-blue-400 hover:text-blue-600">
                        Ver todas
                    </a>
                </div>
            </div>

        </main>
    </div>
</x-layouts.base>