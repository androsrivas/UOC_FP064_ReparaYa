<?php

namespace App\Http\Controllers\Incidencia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Especialidad;
use App\Models\Incidencia;
use App\Models\Tecnico;
use App\Models\User;
use App\Models\Zona;
use App\Http\Requests\Incidencia\StoreIncidenciaRequest;
use App\Http\Requests\Incidencia\UpdateIncidenciaRequest;
use App\Services\IncidenciaService;

class IncidenciaAdminController extends Controller
{
    protected IncidenciaService $incidenciaService;

    public function __construct(IncidenciaService $incidenciaService)
    {
        $this->incidenciaService = $incidenciaService;
    }

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Incidencia::class);

        $incidencias = Incidencia::with(['cliente', 'tecnico', 'especialidad', 'zona'])
            ->when($request->estado, fn($q, $v) => $q->where('estado', $v))
            ->when($request->urgencia, fn($q, $v) => $q->where('tipo_urgencia', $v))
            ->when($request->especialidad, fn($q, $v) => $q->where('especialidad_id', $v))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $especialidades = Especialidad::all();

        return view('incidencias.index', compact('incidencias', 'especialidades'));
    }

    public function create()
    {
        Gate::authorize('create', Incidencia::class);

        $clientes = User::select('email')->get();
        $especialidades = Especialidad::all();
        $zonas = Zona::all();
        $tecnicos = Tecnico::with('especialidad')->where('disponible', true)->get();

        return view('incidencias.create', compact('clientes', 'especialidades', 'zonas', 'tecnicos'));
    }

    public function store(StoreIncidenciaRequest $request)
    {
        $data = $request->validated();

        $cliente = User::where('email', $data['email'])->first();
        $especialidad = Especialidad::find($data['especialidad_id']);

        $data['cliente_id'] = $cliente->id;
        $data['localizador'] = $this->incidenciaService->generarLocalizador();
        $data['estado'] = $data['tecnico_id'] ? 'Asignada' : 'Pendiente';
        $data['precio_base'] = $especialidad->precio_base;
        
        unset($data['email']);

        $this->incidenciaService->crear($data);

        return redirect()->route('incidencias.show', $data['localizador'])->with('success', 'Incidencia creada.');
    }

    public function show(Incidencia $incidencia)
    {
        Gate::authorize('view', $incidencia);

        $incidencia->load(['cliente', 'tecnico.especialidad', 'especialidad', 'zona', 'comision']);
        $tecnicos = Tecnico::with('especialidad')->get();

        return view('incidencias.show', compact('incidencia', 'tecnicos'));
    }

    public function edit(Incidencia $incidencia)
    {
        Gate::authorize('update', $incidencia);

        $especialidades = Especialidad::all();
        $zonas = Zona::all();
        $tecnicos = Tecnico::with('especialidad')->get();

        return view('incidencias.edit', compact('incidencia', 'especialidades', 'zonas', 'tecnicos'));
    }

    public function update(UpdateIncidenciaRequest $request, Incidencia $incidencia)
    {
        $data = $request->validated();

        $incidencia->update($data);

        return redirect()->route('incidencias.show', $incidencia)->with('success', 'Incidencia actualizada exitosamente.');
    }

    public function destroy(Incidencia $incidencia)
    {
        Gate::authorize('delete', $incidencia);

        $this->incidenciaService->cancelar($incidencia);

        return redirect()->route('incidencias.index')->with('success', 'Incidencia cancelada.');
    }

    public function asignarTecnico(Request $request, Incidencia $incidencia)
    {
        Gate::authorize('assign', $incidencia);

        $request->validate([
            'tecnico_id' => 'required|exists:tecnicos,id',
        ]);

        $incidencia->update([
            'tecnico_id' => $request->tecnico_id,
            'estado' => 'Asignada',
        ]);

        return back()->with('success', 'Técnico asignado exitosamente.');
    }

    public function cambiarEstado(Request $request, Incidencia $incidencia)
    {
        Gate::authorize('changeStatus', $incidencia);

        $request->validate([
            'estado' => 'required|in:Pendiente,Asignada,Finalizada,Cancelada',
        ]);

        $this->incidenciaService->actualizarEstado($incidencia, $request->estado);

        return back()->with('success', 'Estado actualizado exitosamente.');
    }

    public function calendario()
    {
        Gate::authorize('viewCalendar', Incidencia::class);

        $incidencias = $this->incidenciaService->getCalendarDataForUser(auth()->user());

        return view('incidencias.calendario', compact('incidencias'));
    }

}
