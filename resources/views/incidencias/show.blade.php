<x-layouts.base title="Detalle">
    <div class="max-w-4xl">

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('incidencias.index') }}" 
                   class="text-gray-400 hover:text-gray-600 transition">←</a>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">
                        {{ $incidencia->localizador }}
                    </h1>
                    <p class="text-sm text-gray-400 mt-0.5">
                        Creada el {{ $incidencia->created_at->format('d/m/Y \a \l\e\s H:i') }}
                    </p>
                </div>
            </div>
            <div class="flex gap-2">
                @if(!in_array($incidencia->estado, ['Finalizada','Cancelada']))
                    <a href="{{ route('incidencias.edit', $incidencia) }}"
                       class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                        Editar
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">

            <div class="col-span-2 flex flex-col gap-6">

                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">
                        Información general
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Especialidad</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $incidencia->especialidad->nombre_especialidad }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Zona</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $incidencia->zona->nombre ?? '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Fecha del servicio</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $incidencia->fecha_servicio->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Urgencia</p>
                            @if($incidencia->tipo_urgencia === 'Urgente')
                                <span class="px-2 py-1 bg-red-50 text-red-600 rounded text-xs font-medium">
                                    Urgente
                                </span>
                            @else
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-medium">
                                    Estándard
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Precio base</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ number_format($incidencia->precio_base, 2) }} €
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Dirección</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $incidencia->direccion }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-400 mb-1">Descripción</p>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            {{ $incidencia->descripcion }}
                        </p>
                    </div>
                </div>

                {{-- Assignació de tècnic --}}
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">
                        Técnico asignado
                    </h2>

                    @if($incidencia->tecnico)
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center 
                                        justify-content-center text-blue-600 font-bold text-sm justify-center">
                                {{ strtoupper(substr($incidencia->tecnico->nombre_completo, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $incidencia->tecnico->nombre_completo }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $incidencia->tecnico->especialidad->nombre_especialidad }}
                                </p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-400 mb-4">Sin técnico asignado.</p>
                    @endif

                    @if(!in_array($incidencia->estado, ['Finalizada','Cancelada']))
                        <form method="POST" 
                              action="{{ route('incidencias.asignarTecnico', $incidencia) }}">
                            @csrf
                            @method('PATCH')
                            <div class="flex gap-3">
                                <select name="tecnico_id"
                                        class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm">
                                    <option value="">Selecciona un técnico...</option>
                                    @foreach($tecnicos as $tec)
                                        <option value="{{ $tec->id }}"
                                            {{ $incidencia->tecnico_id == $tec->id ? 'selected' : '' }}>
                                            {{ $tec->nombre_completo }} 
                                            — {{ $tec->especialidad->nombre_especialidad }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                                    Asignar
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

                {{-- Comissió (si ve de gestora) --}}
                @if($incidencia->comision)
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">
                            Comisión generada
                        </h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">Precio base</p>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ number_format($incidencia->comision->precio_base, 2) }} €
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-1">Porcentaje</p>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $incidencia->comision->porcentaje_aplicado }} %
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-1">Importe comisión</p>
                                <p class="text-lg font-semibold text-green-600">
                                    {{ number_format($incidencia->comision->importe, 2) }} €
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Columna lateral --}}
            <div class="flex flex-col gap-6">

                {{-- Estat --}}
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">
                        Estado
                    </h2>

                    @php
                        $colors = [
                            'Pendiente'  => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                            'Asignada'   => 'bg-blue-50 text-blue-700 border-blue-200',
                            'Finalizada' => 'bg-green-50 text-green-700 border-green-200',
                            'Cancelada'  => 'bg-gray-100 text-gray-500 border-gray-200',
                        ];
                    @endphp

                    <span class="inline-block px-3 py-1.5 rounded-lg text-sm font-medium border 
                                 {{ $colors[$incidencia->estado] ?? '' }}">
                        {{ $incidencia->estado }}
                    </span>

                    @if(!in_array($incidencia->estado, ['Finalizada','Cancelada']))
                        <form method="POST"
                              action="{{ route('incidencias.cambiarEstado', $incidencia) }}"
                              class="mt-4">
                            @csrf
                            @method('PATCH')
                            <select name="estado"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mb-3">
                                @foreach(['Pendiente','Asignada','Finalizada','Cancelada'] as $estat)
                                    <option value="{{ $estat }}"
                                        {{ $incidencia->estado === $estat ? 'selected' : '' }}>
                                        {{ $estat }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                    class="w-full bg-gray-800 text-white py-2 rounded-lg text-sm font-medium hover:bg-gray-900 transition">
                                Actualizar estado
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Client --}}
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">
                        Cliente
                    </h2>
                    <p class="text-sm font-medium text-gray-800">
                        {{ $incidencia->cliente->nombre }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $incidencia->cliente->email }}
                    </p>
                    @if($incidencia->cliente->telefono)
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $incidencia->cliente->telefono }}
                        </p>
                    @endif

                    {{-- Si ve de gestora --}}
                    @if($incidencia->empresaGestora)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-400 mb-1">Empresa gestora</p>
                            <p class="text-sm font-medium text-orange-600">
                                🏢 {{ $incidencia->empresaGestora->nombre }}
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-layouts.base>