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

        $data = match($user->rol) {
            'admin' => $this->getAdminData($user),
            'tecnico' => $this->getTecnicoData($user),
            'gestora' => $this->getGestoraData($user),
            'particular' => $this->getParticularData($user),
            default => abort(403, 'Rol no definido'),
        };

        $data['title'] = 'Dashboard ' . ucfirst($user->rol);

        return view("dashboard.{$user->rol}", $data);
    }

    private function getUltimasIncidencias(User $user)
    {
        $query = Incidencia::with(['cliente', 'especialidad', 'tecnico', 'gestora']);

        match($user->rol) {
            'tecnico' => $query->where('tecnico_id', $user->id),
            'gestora' => $query->where('gestora_id', $user->id),
            'particular' => $query->where('user_id', $user->id)
        };

        return  $query->orderBy('created_at', 'desc')->take(5)->get();
    }

    private function getAdminData(User $user): array {
        $ultimas_incidencias = $this->getUltimasIncidencias($user);
        $incidencias_hoy = Incidencia::whereDate('created_at', Carbon::today())->count();
        $pendientes_asignar = Incidencia::where('estado', 'Pendiente')->count();
        $tecnicos_activos = Tecnico::where('disponible', true)->count();
        $resueltas_mes = Incidencia::where('estado', 'Finalizada')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();

        return [
            'ultimas_incidencias' => $ultimas_incidencias,
            'incidencias_hoy' => $incidencias_hoy,
            'pendientes_asignar' => $pendientes_asignar,
            'tecnicos_activos' => $tecnicos_activos,
            'resueltas_mes' => $resueltas_mes
        ];
    }

    private function getTecnicoData(User $user): array {
        $ultimas_incidencias = $this->getUltimasIncidencias($user);
        $pendientes_hoy = Incidencia::where('tecnico_id', $user->id)
            ->where('estado', 'Pendiente')
            ->whereDate('created_at', Carbon::today())
            ->count();

        return [
            'ultimas_incidencias' => $ultimas_incidencias,
            'pendientes_hoy' => $pendientes_hoy
        ];
    }

    private function getParticularData(User $user): array {
        $incidencias_activas = Incidencia::where('cliente_id', $user->id)->whereIn('estado', ['Pendiente', 'Asignada'])->count();
        $pendientes_visita = Incidencia::where('cliente_id', $user->id)->where('estado', 'Pendiente')->count();
        $finalizadas_mes = Incidencia::where('cliente_id', $user->id)
            ->where('estado', 'Finalizada')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();
        $incidencias = Incidencia::where('cliente_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return [
            'incidencias_activas' => $incidencias_activas,
            'pendientes_visita' => $pendientes_visita,
            'finalizadas_mes' => $finalizadas_mes,
            'incidencias' => $incidencias
        ];
    }

    private function getGestoraData(User $user): array {
        $ultimas_incidencias = $this->getUltimasIncidencias($user);
        $pendientes_asignar = Incidencia::where('gestora_id', $user->id)
            ->where('estado', 'Pendiente')
            ->count();

        return [
            'ultimas_incidencias' => $ultimas_incidencias,
            'pendientes_asignar' => $pendientes_asignar
        ];
    }
}
