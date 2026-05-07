<?php

namespace App\Policies;

use App\Models\Incidencia;
use App\Models\User;

class IncidenciaPolicy
{
    /**
     * Quien puede listar incidencias.
     */
    public function viewAny(User $user, Incidencia $incidencia): bool
    {
        return in_array($user->rol, ['admin', 'tecnico', 'gestora', 'particular']);
    }

    /**
     * Quien puede ver una incidencia específica.
     */
    public function view(User $user, Incidencia $incidencia): bool
    {
        // Admin puede ver todas las incidencias
        if ($user->rol === 'admin') {
            return true;
        }

        if ($user->rol === 'tecnico') {
            // Técnicos pueden ver incidencias asignadas a ellos
            return $incidencia->tecnico_id === $user->id;
        }

        // El cliente/particular solo puede ver sus propias incidencias
        if ($user->rol === 'particular') {
            return $incidencia->cliente_id === $user->id;
        }

        // La gestora puede ver las incidencias que gestiona
        if ($user->rol === 'gestora') {
            return $incidencia->gestora_id === $user->id;
        }

        return false;
    }

    /**
     * Quien puede crear incidencias.
     */
    public function create(User $user): bool
    {
        // Solo admin, gestora y particular pueden crear incidencias
        if (in_array($user->rol, ['admin', 'gestora', 'particular'])) {
            return true;
        }

        return false;
    }

    /**
     * Quien puede actualizar una incidencia.
     */
    public function update(User $user, Incidencia $incidencia): bool
    {
        // Solo admin y gestora pueden actualizar incidencias
        if (in_array($user->rol, ['admin', 'gestora'])) {
            return true;
        }

        return false;
    }

    /**
     * Quien puede eliminar una incidencia.
     */
    public function delete(User $user, Incidencia $incidencia): bool
    {
        if ($user->rol === 'admin') {
            return true;
        }

        return false;
    }

    /**
     * Quien puede restaurar una incidencia.
     */
    public function restore(User $user, Incidencia $incidencia): bool
    {
        if ($user->rol === 'admin') {
            return true;
        }
        
        return false;
    }

    /**
     * Quien puede eliminar permanentemente una incidencia.
     */
    public function forceDelete(User $user, Incidencia $incidencia): bool
    {
        if ($user->rol === 'admin') {
            return true;
        }

        return false;
    }

    public function assign(User $user, Incidencia $incidencia): bool
    {
        // Solo admin puede asignar técnicos a incidencias
        if ($user->rol === 'admin') {
            return true;
        }

        return false;
    }

    /**
     * Quien puede cambiar el estado de una incidencia.
     */
    public function changeStatus(User $user, Incidencia $incidencia): bool
    {
        // Solo admin puede cambiar el estado de una incidencia
        if ($user->rol === 'admin') {
            return true;
        }

        // Solo la gestora puede cambiar el estado de las incidencias que gestiona
        if ($user->rol === 'gestora') {
            return $incidencia->gestora_id === $user->id;
        }

        // Solo el tecnico asignado puede cambiar el estado de la incidencia
        if ($user->rol === 'tecnico') {
            return $incidencia->tecnico_id === $user->id;
        }

        return false;
    }

    public function cancel(User $user, Incidencia $incidencia): bool
    {
        // Solo el cliente/particular puede cancelar sus propias incidencias
        if ($user->rol === 'particular') {
            return $incidencia->cliente_id === $user->id && $incidencia->puedeCancelar();
        }

        // La gestora puede cancelar las incidencias que gestiona
        if ($user->rol === 'gestora') {
            return $incidencia->gestora_id === $user->id;
        }

        // Solo admin puede cancelar cualquier incidencia
        if ($user->rol === 'admin') {
            return true;
        }

        return false;
    }

    public function viewComision(User $user, Incidencia $incidencia): bool
    {
        // Solo admin puede ver la comisión de una incidencia
        if ($user->rol === 'admin') {
            return true;
        }

        // Solo la gestora puede ver la comisión de las incidencias que gestiona
        if ($user->rol === 'gestora') {
            return $incidencia->gestora_id === $user->id;
        }

        return false;
    }
}
