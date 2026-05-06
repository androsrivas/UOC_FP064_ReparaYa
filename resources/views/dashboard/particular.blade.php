<x-layouts.cliente>
    <x-slot name="title">Mis Reparaciones — ReparaYa</x-slot>

    @php
        $breadcrumbItems = ['Mi Panel' => '#'];
    @endphp

    <header class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h1 class="mb-1 font-serif text-3xl text-blue-950">¡Hola, {{ auth()->user()->name }}!</h1>
            <p class="text-sm text-slate-500">Aquí puedes seguir el estado de tus incidencias abiertas.</p>
        </div>
        <div>
            <a href="{{ route('cliente.incidencias.nueva-incidencia') }}" class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-800 transition-all">
                + Reportar Avería
            </a>
        </div>
    </header>

    <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-2 text-sm text-slate-500">En curso</div>
            <div class="font-serif text-3xl leading-none text-blue-600">{{ $incidencias_activas }}</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-2 text-sm text-slate-500">Pendientes de visita</div>
            <div class="font-serif text-3xl leading-none text-orange-500">{{ $pendientes_visita }}</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-2 text-sm text-slate-500">Finalizadas este mes</div>
            <div class="font-serif text-3xl leading-none text-teal-600">{{ $finalizadas_mes }}</div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5 text-lg font-serif text-blue-950">
            Estado de mis solicitudes
        </div>
        <x-shared.table>
            <x-slot name="thead">
                <th class="px-6 py-4 font-medium">Localizador</th>
                <th class="px-6 py-4 font-medium">Descripción</th>
                <th class="px-6 py-4 font-medium">Estado</th>
                <th class="px-6 py-4 font-medium text-right">Acción</th>
            </x-slot>

            @forelse($incidencias as $incidencia)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-blue-950">{{ $incidencia->localizador }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">{{ $incidencia->titulo }}</div>
                        <div class="text-xs text-slate-500">{{ $incidencia->created_at->format('d/m/Y') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <x-ui.badge :estado="$incidencia->estado" />
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('cliente.incidencias.show', $incidencia) }}" class="text-blue-600 hover:text-blue-900 font-semibold">
                            Ver detalles
                        </a>
                        @if($incidencia->puedeCancelar())
                            <form action="{{ route('cliente.incidencias.cancelar', $incidencia) }}" 
                                method="POST" 
                                onsubmit="return confirm('¿Seguro que deseas cancelar esta incidencia? Recuerda que solo se puede hacer con 48h de antelación.')">
                                @csrf
                                @method('DELETE')
                                
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm transition-colors">
                                    Cancelar
                                </button>
                            </form>
                        @else
                            <span class="text-slate-300 cursor-not-allowed" title="{{ $incidencia->estado === 'Finalizada' ? 'Ya está terminada' : 'Quedan menos de 48h' }}">
                                <i class="fas fa-lock text-xs"></i>
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                        No tienes incidencias registradas.
                    </td>
                </tr>
            @endforelse
        </x-shared.table>>
    </div>
</x-layouts.cliente>