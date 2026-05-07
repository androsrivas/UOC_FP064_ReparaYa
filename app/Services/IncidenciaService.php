<?php

namespace App\Services;

use App\Models\Comision;
use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class IncidenciaService
{
    public function crear(array $data): Incidencia
    {
        return DB::transaction(function () use ($data) {
            $incidencia = Incidencia::create($data);

            return $incidencia;
        });
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
                'cancelada_por' => auth()->id(),
            ]);

            return [
                'success' => true,
                'message' => 'Incidencia cancelada correctamente.'
            ];
        } catch (\Exception $e) {
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

    public function getCalendarDataForUser(User $user)
    {
        $query = Incidencia::with(['cliente', 'tecnico', 'especialidad'])
            ->whereNotIn('estado', ['Cancelada']);

        if ($user->rol === 'tecnico') {
            $query->where('tecnico_id', $user->id);
        }

        return $query->get()->map(fn($inc) => [
            'REF:'             => $inc->localizador,
            'title'          => "{$inc->titulo} - {$inc->cliente->name}",
            'url'            => route('incidencias.show', $inc->id),

            'extendedProps' => [
                'tecnico'      => $inc->tecnico?->name ?? 'Sin asignar',
                'especialidad' => $inc->especialidad->nombre_especialidad,
                'urgencia'     => $inc->tipo_urgencia,
            ],

            'backgroundColor' => $this->getColorPorEstado($inc->estado),
            'borderColor'     => $this->getColorPorEstado($inc->estado),
            'textColor'       => '#ffffff',
        ]);
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
