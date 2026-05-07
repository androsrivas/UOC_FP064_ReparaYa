<?php 

namespace App\Services;

use App\Models\Incidencia;

class IncidenciaService
{
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
}
