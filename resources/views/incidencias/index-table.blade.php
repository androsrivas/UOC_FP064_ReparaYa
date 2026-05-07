@props(['incidencias'])

<x-shared.table {{ $attributes }}>
    <x-slot name="thead">
        <th class="px-6 py-4 font-semibold text-slate-900">Localizador</th>
        <th class="px-6 py-4 font-semibold text-slate-900">Estado</th>
        <th class="px-6 py-4 font-semibold text-slate-900">Especialidad</th>
        
        {{-- Solo admin y gestora ven quién es el cliente --}}
        @if(auth()->user()->rol !== 'particular')
            <th class="px-6 py-4 font-semibold text-slate-900">Cliente</th>
        @endif

        <th class="px-6 py-4 font-semibold text-slate-900 text-right">Acciones</th>
    </x-slot>

    @foreach($incidencias as $incidencia)
        <tr class="hover:bg-slate-50 transition-colors">
            <td class="px-6 py-4 font-medium text-blue-600">{{ $incidencia->localizador }}</td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $incidencia->estado_color }}">
                    {{ $incidencia->estado }}
                </span>
            </td>
            <td class="px-6 py-4">{{ $incidencia->especialidad->nombre_especialidad }}</td>

            @if(auth()->user()->rol !== 'particular')
                <td class="px-6 py-4 text-slate-500">{{ $incidencia->cliente->name }}</td>
            @endif

            <td class="px-6 py-4 text-right space-x-3">
                <a href="{{ route('incidencias.show', $incidencia) }}" class="text-slate-400 hover:text-blue-600">
                    <i class="fa-solid fa-eye"></i>
                </a>
                
                @can('update', $incidencia)
                    <a href="{{ route('incidencias.edit', $incidencia) }}" class="text-slate-400 hover:text-amber-600">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                @endcan
            </td>
        </tr>
    @endforeach
</x-shared.table>