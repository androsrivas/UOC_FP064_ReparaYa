<x-layouts.base title="Incidencias">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Incidències</h1>
        <a href="{{ route('incidencias.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            + Nueva incidencia
        </a>
    </div>

    <form method="GET" class="flex gap-3 mb-6 flex-wrap">
        <select name="estado" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Todos los estados</option>
            @foreach(['Pendiente','Asignada','Finalizada','Cancelada'] as $e)
                <option value="{{ $e }}" {{ request('estado') == $e ? 'selected' : '' }}>
                    {{ $e }}
                </option>
            @endforeach
        </select>

        <select name="urgencia" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Todas las urgencias</option>
            <option value="Urgente"  {{ request('urgencia') == 'Urgente'  ? 'selected' : '' }}>Urgente</option>
            <option value="Estándar" {{ request('urgencia') == 'Estándar' ? 'selected' : '' }}>Estándard</option>
        </select>

        <select name="especialidad" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Todas las especialidades</option>
            @foreach($especialidades as $esp)
                <option value="{{ $esp->id }}" {{ request('especialidad') == $esp->id ? 'selected' : '' }}>
                    {{ $esp->nombre_especialidad }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-900 transition">
            Filtrar
        </button>
        <a href="{{ route('incidencias.index') }}"
           class="text-sm text-gray-400 hover:text-gray-600 self-center transition">
            Limpiar filtros
        </a>
    </form>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-left">Localizador</th>
                    <th class="px-4 py-3 text-left">Cliente</th>
                    <th class="px-4 py-3 text-left">Especialidad</th>
                    <th class="px-4 py-3 text-left">Fecha servicio</th>
                    <th class="px-4 py-3 text-left">Ugrencia</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left">Técnico</th>
                    <th class="px-4 py-3 text-left">Precio</th>
                    <th class="px-4 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($incidencias as $inc)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-mono text-xs text-blue-600 font-medium">
                        {{ $inc->localizador }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-800">{{ $inc->cliente->nombre }}</div>
                        @if($inc->empresaGestora)
                            <div class="text-xs text-orange-500 mt-0.5">
                                🏢 {{ $inc->empresaGestora->nombre }}
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ $inc->especialidad->nombre_especialidad }}
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ $inc->fecha_servicio->format('d/m/Y') }}<br>
                        <span class="text-xs text-gray-400">{{ $inc->fecha_servicio->format('H:i') }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @if($inc->tipo_urgencia === 'Urgente')
                            <span class="px-2 py-1 bg-red-50 text-red-600 rounded text-xs font-medium">
                                Urgent
                            </span>
                        @else
                            <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-medium">
                                Estándard
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $colores = [
                                'Pendiente'  => 'bg-yellow-50 text-yellow-700',
                                'Asignada'   => 'bg-blue-50 text-blue-700',
                                'Finalizada' => 'bg-green-50 text-green-700',
                                'Cancelada'  => 'bg-gray-100 text-gray-500',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-medium {{ $colores[$inc->estado] ?? '' }}">
                            {{ $inc->estado }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-sm">
                        {{ $inc->tecnico?->nombre_completo ?? '—' }}
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-sm">
                        {{ number_format($inc->precio_base, 2) }} €
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-3">
                            <a href="{{ route('incidencias.show', $inc) }}"
                               class="text-blue-600 hover:underline text-xs font-medium">
                                Ver
                            </a>
                            @if(!in_array($inc->estado, ['Finalizada','Cancelada']))
                                <a href="{{ route('incidencias.edit', $inc) }}"
                                   class="text-gray-500 hover:underline text-xs">
                                    Editar
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-10 text-center text-gray-400 text-sm">
                        No hya incidencias que coincidan con los filtros.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $incidencias->links() }}
    </div>

</x-layouts.base>