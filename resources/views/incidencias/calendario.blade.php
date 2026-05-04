<x-layouts.base title="Calendari">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Calendario de servicios</h1>
        <a href="{{ route('incidencias.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            + Nueva incidencia
        </a>
    </div>

    {{-- Leyenda --}}
    <div class="flex gap-4 mb-4 flex-wrap">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span> Urgente
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span> Estándar
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span> Finalizada
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span class="w-3 h-3 rounded-full bg-gray-400 inline-block"></span> Cancelada
        </div>
    </div>

    {{-- Calendari --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div id="calendari"></div>
    </div>

    {{-- Modal detalle --}}
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 
                            flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <div class="flex items-start justify-between mb-4">
                <h3 id="modal-localitzador"
                    class="text-lg font-semibold text-gray-800 font-mono"></h3>
                <button onclick="cerrarModal()"
                        class="text-gray-400 hover:text-gray-600 text-xl leading-none">×</button>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-400">Cliente</span>
                    <span id="modal-client" class="font-medium text-gray-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Especialidad</span>
                    <span id="modal-especialitat" class="font-medium text-gray-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Fecha</span>
                    <span id="modal-data" class="font-medium text-gray-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Dirección</span>
                    <span id="modal-adreca" class="font-medium text-gray-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Técnico</span>
                    <span id="modal-tecnic" class="font-medium text-gray-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Estado</span>
                    <span id="modal-estat" class="font-medium"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Urgencia</span>
                    <span id="modal-urgencia" class="font-medium"></span>
                </div>
                <div class="pt-2 border-t border-gray-100">
                    <p class="text-gray-400 mb-1">Descripció</p>
                    <p id="modal-descripcio" class="text-gray-700 leading-relaxed"></p>
                </div>
            </div>
            <div class="mt-5 flex gap-2">
                <a id="modal-link" href="#"
                   class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    Ver detalle completo
                </a>
                <button onclick="cerrarModal()"
                        class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script>
        const incidencias = @json($incidencias);

        const colorMap = {
            'Urgente-Pendiente':  '#EF4444',
            'Urgente-Asignada':   '#F97316',
            'Estándar-Pendiente': '#3B82F6',
            'Estándar-Asignada':  '#6366F1',
            'Finalizada':         '#22C55E',
            'Cancelada':          '#9CA3AF',
        };

        function getColor(inc) {
            if (inc.estado === 'Finalizada') return colorMap['Finalizada'];
            if (inc.estado === 'Cancelada')  return colorMap['Cancelada'];
            return colorMap[`${inc.tipo_urgencia}-${inc.estado}`] ?? '#3B82F6';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const cal = new FullCalendar.Calendar(document.getElementById('calendari'), {
                initialView:  'dayGridMonth',
                locale:       'ca',
                headerToolbar: {
                    left:   'prev,next today',
                    center: 'title',
                    right:  'dayGridMonth,timeGridWeek,timeGridDay',
                },
                height: 650,
                events: incidencias.map(inc => ({
                    id:    inc.id,
                    title: `${inc.localizador} — ${inc.especialidad}`,
                    start: inc.fecha_servicio,
                    color: getColor(inc),
                    extendedProps: inc,
                })),
                eventClick: function (info) {
                    obrirModal(info.event.extendedProps);
                },
            });

            cal.render();
        });

        function abrirModal(inc) {
            document.getElementById('modal-localitzador').textContent = inc.localizador;
            document.getElementById('modal-client').textContent       = inc.client;
            document.getElementById('modal-especialitat').textContent = inc.especialidad;
            document.getElementById('modal-data').textContent         = inc.fecha_servicio_fmt;
            document.getElementById('modal-adreca').textContent       = inc.direccion;
            document.getElementById('modal-tecnic').textContent       = inc.tecnic ?? 'Sin asignar';
            document.getElementById('modal-estat').textContent        = inc.estado;
            document.getElementById('modal-urgencia').textContent     = inc.tipo_urgencia;
            document.getElementById('modal-descripcio').textContent   = inc.descripcion;
            document.getElementById('modal-link').href                = inc.url_detall;
            document.getElementById('modal').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        document.getElementById('modal').addEventListener('click', function (e) {
            if (e.target === this) cerrarModal();
        });
    </script>

</x-layouts.base>