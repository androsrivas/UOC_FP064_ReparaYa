<?php

namespace App\Services;

use App\DTOs\CalendarEvent;
use App\Models\Comision;
use App\Models\Especialidad;
use App\Models\Incidencia;
use App\Models\Tecnico;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncidenciaService
{
    public function verTodas(): Collection
    {
        return Incidencia::with(['cliente', 'tecnico', 'especialidad', 'zona'])->get()->paginate(15)->withQueryString();
    }

    public function verPorCliente(int $cliente_id): Collection
    {
        return Incidencia::with(['especialidad', 'tecnico', 'zona'])
            ->where('cliente_id', $cliente_id)
            ->orderByDesc('created_at')
            ->get()
            ->paginate(15)
            ->withQueryString();
    }

    public function verDetalle(Incidencia $incidencia): array
    {
        return [
            'incidencia' => $incidencia->load(['cliente', 'tecnico.especialidad', 'especialidad', 'zona', 'comision']),
            'tecnicos' => Tecnico::with('especialidad')->where('disponible', true),
        ];
    }

    public function crearParaAdmin(array $data): Incidencia
    {
        $especialidad = Especialidad::findOrFail($data['especialidad_id']);

        $data['localizador'] = $this->generarLocalizador();
        $data['precio_base'] = $this->$especialidad->precio_base;
        $data['estado'] = !empty($data['tecnico_id']) ? 'Asignada' : 'Pendiente';

        return Incidencia::create($data);
    }

    public function crearParaCliente(array $data): Incidencia
    {

        $especialidad = Especialidad::findOrFail($data['especialidad_id']);

        $data['cliente_id'] = Auth::id();
        $data['precio_base'] = $this->$especialidad->precio_base;
        $data['estado'] = 'Pendiente';
        $data['localizador'] = $this->generarLocalizador();

        return Incidencia::create($data);
    }

    public function actualizarEstado(Incidencia $incidencia, string $nuevoEstado): void
    {
        $incidencia->update(['estado' => $nuevoEstado]);

        if ($nuevoEstado === 'Finalizada' && $incidencia->empresa_gestora_id) {
            $this->generarComision($incidencia);
        }
    }

    public function generarLocalizador()
    {
        do {
            $codigo = 'REP-' . date('Y') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Incidencia::where('localizador', $codigo)->exists());

        return $codigo;
    }

    private function generarComision(Incidencia $incidencia)
    {
        $gestora = $incidencia->cliente->empresaGestora;

        Comision::create([
            'gestora_id' => $gestora->id,
            'incidencia_id' => $incidencia->id,
            'precio_base' => $incidencia->precio_base,
            'porcentaje_aplicado' => $gestora->porcentaje_comision,
            'importe' => round($incidencia->precio_base * $gestora->porcentaje_comision / 100, 2),
            'mes' => now()->month,
            'anyo' => now()->year,
        ]);
    }

    public function puedeCancelar(Incidencia $incidencia): bool
    {
        $conSuficienteAntelacion = now()->addHours(48)->isBefore($incidencia->fecha_servicio);
        $estadoValido = !in_array($incidencia->estado, ['Cancelada', 'Asignada', 'Finalizada']);

        return $conSuficienteAntelacion && $estadoValido;
    }

    public function cancelar(Incidencia $incidencia): array
    {
        try {
            $incidencia->update([
                'estado' => 'Cancelada',
                'cancelada_at' => now(),
                'cancelada_por' => Auth::id(),
            ]);

            return [
                'success' => true,
                'message' => 'Incidencia cancelada correctamente.'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'No se ha podido procesar la cancelación.'
            ];
        }
    }

    public function motivoCancelacion(Incidencia $incidencia): ?string
    {
        if (in_array($incidencia->estado, ['Finalizada', 'Cancelada'])) {
            return "Esta incidencia ya ha finalizado.";
        }

        if ($incidencia->estado === 'Asignada') {
            return "No puedes cancelar una incidencia que ya tiene un técnico asignado. Contacta con tu gestora para más información.";
        }

        if (!now()->addHours(48)->isBefore($incidencia->fecha_servicio)) {
            return "Faltan menos de 48 horas para el servicio.";
        }

        return null;
    }

    public function getCalendarEvents(?int $userId = null): array
    {
        $user = $userId ? User::findOrFail($userId) : Auth::user();
        $query = Incidencia::with(['cliente', 'tecnico', 'especialidad']);

        if ($user->isTecnico()) {
            $query->where('tecnico_id', $user->tecnico->id);
        } elseif($user->isAdmin()) {
            $query->whereNotNull('tecnico_id');
        }

        return $query->whereNotIn('estado', ['Cancelada'])
            ->get()
            ->map(fn(Incidencia $inc): array => ( new CalendarEvent(
                localizador: $inc->localizador,
                title: $inc->titulo,
                start: $inc->fecha_servicio,
                end: $inc->fecha_servicio,
                color: $this->getColorPorEstado($inc->estado),
                extendedProps: [
                    'cliente' => $inc->cliente->nombre,
                    'especialidad' => $inc->especialidad->nombre_especialidad,
                    'url_detalle' => route('incidencias.show', $inc->id),
                ],
            ))->toArray())
            ->toArray();
    }

    private function getColorPorEstado(string $estado): string
    {
        return match ($estado) {
            'Pendiente'  => '#f59e0b',
            'Asignada'   => '#3b82f6',
            'Finalizada' => '#10b981',
            'Cancelada'  => '#ef4444',
            default      => '#64748b',
        };
    }
}
