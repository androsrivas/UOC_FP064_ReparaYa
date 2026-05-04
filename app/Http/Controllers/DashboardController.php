<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Tecnico;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $vista = match($user->rol) {
            'admin' => 'dashboard.admin',
            'tecnico' => 'dashboard.tecnico',
            'gestora' => 'dashboard.gestora',
            default => 'dashboard.particular',
        };

        return view($vista);
    }

    public function getultimasIncidencias(User $user)
    {
        $query = Incidencia::with(['user', 'especialidad', 'tecnico', 'estado', 'gestora']);

        if ($user->rol === 'tecnico') {
            $query->where('tecnico_id', $user->id);
        } elseif ($user->rol === 'gestora') {
            $query->where('gestora_id', $user->id);
        } elseif ($user->rol === 'particular') {
            $query->where('user_id', $user->id);
        }

        return  $query->orderBy('created_at', 'desc')->take(5)->get();
    }

    public function getAdminData(User $user): array {
        $ultimas_incidencias = $this->getultimasIncidencias($user);
        $incidencias_hoy = Incidencia::whereDate('created_at', Carbon::today())->count();
        $pendientes_asignar = Incidencia::where('estado', 'Pendiente')->count();
        $tecnicos_activos = Tecnico::where('disponible', true)->count();
        $resultas_mes = Incidencia::where('estado', 'Finalizada')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();

        return [
            'ultimas_incidencias' => $ultimas_incidencias,
            'incidencias_hoy' => $incidencias_hoy,
            'pendientes_asignar' => $pendientes_asignar,
            'tecnicos_activos' => $tecnicos_activos,
            'resultas_mes' => $resultas_mes
        ];
    }

    public function getTecnicoData(User $user): array {
        $ultimas_incidencias = $this->getultimasIncidencias($user);
        $pendientes_hoy = Incidencia::where('tecnico_id', $user->id)
            ->where('estado', 'Pendiente')
            ->whereDate('created_at', Carbon::today())
            ->count();

        return [
            'ultimas_incidencias' => $ultimas_incidencias,
            'pendientes_hoy' => $pendientes_hoy
        ];
    }
}
