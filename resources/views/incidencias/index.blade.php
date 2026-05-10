<x-layouts.cliente>
    <header class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Panel de Incidencias</h1>
        
        @can('create', App\Models\Incidencia::class)
            <x-shared.button href="{{ route('incidencias.create') }}">
                Nueva Solicitud
            </x-shared.button>
        @endcan
    </header>

    <x-incidencias.index-table :incidencias="$incidencias" class="mt-4" />

    <div class="mt-6">
        {{ $incidencias->links() }}
    </div>
</x-layouts.cliente>