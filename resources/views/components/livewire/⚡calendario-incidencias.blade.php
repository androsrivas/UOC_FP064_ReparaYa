<?php

use Livewire\Component;
use App\Services\IncidenciaService;
use Illuminate\Support\Facades\Auth;
use App\Models\Tecnico;
use App\Models\Incidencia;

new class extends Component
{
    public string $tecnicoId = '';
    public string $tecnicoName = '';
    public string $searchQuery = '';


    public function with(IncidenciaService $incidenciaService, TecnicoService $tecnicoService): array
    {
        $user = Auth::user();
        $isAdmin = $user->isAdmin();

        $suggestedTecnicos = ($isAdmin && strlen($this->searchQuery) > 1)
            ? $tecnicoService->searchTecnicosByName($this->searchQuery)
            : collect();
        
        if ($user->isTecnico()) {
            $idFilter = $user->id;
        } else {
            $idFilter = $this->tecnicoId ? (int) $this->tecnicoId : null;
        }

        return [
            'incidencias' => $incidenciaService->getCalendarEvents($idFilter ?: null),
            'tecnicos' => $tecnicoService->getTecnicos(),
            'isAdmin' => $user->isAdmin(),
        ];
    }
    
    public function selectTecnico(int $id, string $nombre): void
    {
        $this->tecnicoId = (string) $id;
        $this->tecnicoName = $nombre;
        $this->searchQuery = '';
        $this->dispatch('calendar-updated');
    }

    public function clearFilter(): void
    {
        $this->reset(['tecnicoId', 'tecnicoName', 'searchQuery']);
        $this->dispatch('calendar-updated');
    }

    public function actualizarFecha(int $id, string $fechaStr): void
    {
        $incidencia = Incidencia::findOrFail($id);

        Gate::authorize('update', $incidencia);

        $incidencia->update(['fecha_servicio' => $fechaStr]);
        $this->dispatch('calendar-updated');
    }

};
?>

<div class="p-6">
    @if($isAdmin)
        <div class="mb-6 flex items-center gap-4">
            <span class="text-sm font-bold text-slate-400">Filtrar por técnico:</span>
            
            <div class="flex items-center gap-4">
                <div class="w-full max-w-md">
                    <x-search-input
                        wire:model.live.debounce.300ms="searchQuery"
                        :results="$results"
                        placeholder="Escribe el nombre del técnico..."
                        @selected="selectTenico($event.detail.id, $event.detail.name)"
                    /> 
                </div>
                
                @if($tecnicoId)
                <div class="flex items-center gap-2 px-3 py-2 bg-cyan-900/30 border border-cyan500/50 rounded-xl">
                    <span class="text-sm text-cyan-400">Viendo a: <strong>{{ $tecnicoName }}</strong></span>
                    <button wire:click="clearFilter" class="text-cyan-400 hover:text-white">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                @endif
            </div>
        </div>
    @endif
        
    <div wire:ignore class="rounded-3xl border border-slate-800 bg-slate-900 p-6 shadow-2xl">
        <div id="calendar"></div>
    </div>

    @script
    <script>
        let calendar;

        function renderCalendar() {
            const calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                editable: true,
                events: $wire.incidencias,
                eventDrop: (info) => $wire.actualizarFecha(info.event.id, info.event.startStr),
                eventClick: (info) => {
                    if (info.el.dataset.clickedOnce) {
                        window.location.href = info.event.extendedProps.url_detalle;
                    } else {
                        info.el.dataset.clickedOnce = "true";
                        setTimeOut(() => info.el.dataset.clickedOnce = "", 300);
                        abrirModal(info.event.extendedProps);
                    }
                }
            });
            calendar.render();
        }

        renderCalendar();

        $wire.on('calendar-updated', () => {
            calendar.removeAllEvents();
            calendar.addEventSource($wire.incidencias);
        });
    </script>
    @endscript
</div>