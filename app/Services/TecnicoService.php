<?php 

namespace App\Services;

use App\Models\Tecnico;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TecnicoService
{
    public function verTodos(): LengthAwarePaginator
    {
        return Tecnico::with(['usuario', 'especialidad'])
            ->orderBy('nombre_completo')
            ->paginate(15)->withQueryString();
    }

    public function verPorEspecialidad(int $especialidad_id): LengthAwarePaginator
    {
        return Tecnico::with(['especialidad'])
            ->where('especialidad_id', $especialidad_id)
            ->paginate(5)
            ->withQueryString();
    }

    public function verDetalle(Tecnico $tecnico): array
    {
        $tecnico->load(['usuario', 'especialidad']);

        return [
            'tecnico' => $tecnico,
            'nombre_especialidad' => $tecnico->especialidad?->nombre_especialidad ?? 'Sin especialidad asignada',
            'total_incidencias' => $tecnico->incidencias()->count(),
            'incidencias_pendientes' => $tecnico->incidencias()->where('estado', 'Asignada')->count(),
            'ultimas_incidencias' => $tecnico->incidencias()->latest()->limit(5)->get(),
        ];
    }

    public function crearConUsuario(array $userData, array $tecnicoData): Tecnico
    {
        return DB::transaction(function () use ($userData, $tecnicoData) {
            $usuario = User::create([
                'nombre' => $userData['nombre'],
                'email' => $userData['email'],
                'password' => bcrypt($userData['password']),
                'rol' => 'tecnico',
            ]);

            return Tecnico::create([
                'usuario_id' => $usuario->id,
                'nombre_completo' => $tecnicoData['nombre_completo'] ?? $usuario->nombre,
                'especialidad_id' => $tecnicoData['especialidad_id'],
                'disponible' => $tecnicoData['disponible'] ?? true,
            ]);
        });
    }

    public function editarConUsuario(Tecnico $tecnico, array $data): bool 
    {
        try {
            return DB::transaction(function () use ($tecnico, $data) {
                if ($tecnico->usuario) {
                    $tecnico->usuario->update([
                        'nombre' => $data['nombre'],
                        'email' => $data['email']
                    ]);
                }

                return $tecnico->update([
                    'nombre_completo' => $data['nombre'],
                    'telefono' => $data['telefono'] ?? $tecnico->telefono,
                    'disponible' => $data['disponible'] ?? false,
                    'especialidad_id' => $data['especialidad_id'] ?? $tecnico->especialidad_id,
                ]);
            });
        } catch(\Exception $e) {
            return false;
        }
    }
}

?>
