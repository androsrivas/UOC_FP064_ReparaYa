<x-layouts.admin>
    <x-slot name="title">Panel de Control — ReparaYa</x-slot>

    <header class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h1 class="mb-1 font-serif text-3xl text-blue-950">Hola, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-slate-500">Aquí tienes el resumen de la actividad de hoy.</p>
        </div>
        <div>
            <a href="{{ route('incidencias.create') }}" class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-800">
                + Nueva Incidencia
            </a>
        </div>
    </header>

    <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <x-ui.stats-card title="Incidencias de hoy" :value="$incidencias_hoy" color="text-blue-950" />
        <x-ui.stats-card title="Pendientes de Asignar" :value="$pendientes_asignar" color="text-orange-600" />
        <x-ui.stats-card title="Técnicos Activos" :value="$tecnicos_activos" color="text-blue-950" />
        <x-ui.stats-card title="Resueltas este mes" :value="$resueltas_mes" color="text-teal-600" />
    </div>

    <div class="mb-4 flex items-center justify-between px-2">
    <h2 class="font-serif text-xl text-blue-950">Últimas incidencias reportadas</h2>
    <a href="{{ route('incidencias.index') }}" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 transition-colors hover:border-blue-400 hover:text-blue-600 shadow-sm">
        Ver todas
    </a>
</div>

<x-shared.table>
    <x-slot name="thead">
        <th class="px-6 py-3 font-medium">Referencia / Asunto</th>
        <th class="px-6 py-3 font-medium">Estado</th>
        <th class="px-6 py-3 font-medium">Fecha</th>
        <th class="px-6 py-3 text-right font-medium">Acción</th>
    </x-slot>

    @forelse($ultimas_incidencias as $incidencia)
        <tr class="transition-colors hover:bg-slate-50">
            <td class="px-6 py-4">
                <div class="font-medium text-slate-800">{{ $incidencia->descripcion ?? 'Sin título' }}</div>
                <div class="mt-0.5 text-xs text-slate-400">{{ $incidencia->localizador }}</div>
            </td>
            <td class="px-6 py-4">
                <span class="inline-flex items-center rounded-full border px-2 py-1 text-xs font-medium
                    {{ $incidencia->estado === 'Pendiente' ? 'border-orange-200 bg-orange-50 text-orange-600' : '' }}
                    {{ $incidencia->estado === 'En curso' ? 'border-blue-200 bg-blue-50 text-blue-600' : '' }}
                    {{ $incidencia->estado === 'Finalizada' ? 'border-teal-200 bg-teal-50 text-teal-600' : '' }}
                    {{ $incidencia->estado === 'Cancelada' ? 'border-red-200 bg-red-50 text-red-600' : '' }}
                ">
                    {{ $incidencia->estado }}
                </span>
            </td>
            <td class="px-6 py-4">
                {{ $incidencia->created_at->format('d/m/Y') }}
            </td>
            <td class="px-6 py-4 text-right">
                <a href="{{ route('incidencias.show', $incidencia) }}" class="font-medium text-blue-600 transition-colors hover:text-blue-800">
                    Ver
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-400">
                No hay ninguna incidencia registrada todavía.
            </td>
        </tr>
    @endforelse
</x-shared.table>
</x-layouts.admin>