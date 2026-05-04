@php $edit = isset($incidencia); @endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    {{-- Cliente — solo admin al crear --}}
    @if(!$edit)
    <div class="col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Email del cliente *
        </label>
        <input type="email" name="cliente_email"
               placeholder="email@exemple.com"
               value="{{ old('cliente_email') }}"
               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm 
                      focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('cliente_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    @endif

    {{-- Especialidad --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Especialidad *</label>
        <select name="especialidad_id" id="especialidad_id"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Selecciona...</option>
            @foreach($especialidades as $esp)
                <option value="{{ $esp->id }}"
                        data-preu="{{ $esp->precio_base }}"
                    {{ old('especialidad_id', $incidencia->especialidad_id ?? '') == $esp->id ? 'selected' : '' }}>
                    {{ $esp->nombre_especialidad }} — {{ number_format($esp->precio_base, 2) }} €
                </option>
            @endforeach
        </select>
        @error('especialidad_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Zona --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Zona *</label>
        <select name="zona_id"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Selecciona...</option>
            @foreach($zonas as $zona)
                <option value="{{ $zona->id }}"
                    {{ old('zona_id', $incidencia->zona_id ?? '') == $zona->id ? 'selected' : '' }}>
                    {{ $zona->nombre }}
                </option>
            @endforeach
        </select>
        @error('zona_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Fecha y hora --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha del servicio *</label>
        <input type="datetime-local" name="fecha_servicio"
               value="{{ old('fecha_servicio', isset($incidencia) ? $incidencia->fecha_servicio->format('Y-m-d\TH:i') : '') }}"
               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm 
                      focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('fecha_servicio')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Urgencia --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Urgencia *</label>
        <select name="tipo_urgencia"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="Estándar"
                {{ old('tipo_urgencia', $incidencia->tipo_urgencia ?? '') == 'Estándar' ? 'selected' : '' }}>
                Estándar
            </option>
            <option value="Urgente"
                {{ old('tipo_urgencia', $incidencia->tipo_urgencia ?? '') == 'Urgente' ? 'selected' : '' }}>
                Urgente (24h)
            </option>
        </select>
        @error('tipo_urgencia')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Dirección --}}
    <div class="col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección *</label>
        <input type="text" name="direccion"
               value="{{ old('direccion', $incidencia->direccion ?? '') }}"
               placeholder="Carrer, número, pis, població..."
               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm 
                      focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('direccion')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Descripción --}}
    <div class="col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Descripción de la incidencia *
        </label>
        <textarea name="descripcion" rows="4"
                  placeholder="Describe la incidencia con el máximo detalle posible..."
                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm 
                         resize-none focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion', $incidencia->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Precio base — editable por admin --}}
    @if(auth()->user()->isAdmin())
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Precio base (€)
            <span class="text-gray-400 font-normal text-xs ml-1">— en base a la especialidad</span>
        </label>
        <input type="number" step="0.01" min="0" name="precio_base"
               id="precio_base"
               value="{{ old('precio_base', $incidencia->precio_base ?? '') }}"
               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm 
                      focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    @endif

    {{-- Técnico --}}
    @if(auth()->user()->isAdmin() && isset($tecnicos))
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Asignar técnico
            <span class="text-gray-400 font-normal text-xs ml-1">— opcional</span>
        </label>
        <select name="tecnico_id"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Sin asignar</option>
            @foreach($tecnicos as $tec)
                <option value="{{ $tec->id }}"
                    {{ old('tecnico_id', $incidencia->tecnico_id ?? '') == $tec->id ? 'selected' : '' }}>
                    {{ $tec->nombre_completo }} — {{ $tec->especialidad->nombre_especialidad }}
                </option>
            @endforeach
        </select>
    </div>
    @endif

</div>

{{-- JS: actualitzar precio base al seleccionar especialidad --}}
@if(auth()->user()->isAdmin())
<script>
    document.getElementById('especialidad_id')?.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const preu     = selected.dataset.preu ?? '';
        const input    = document.getElementById('precio_base');
        if (input && preu) input.value = preu;
    });
</script>
@endif