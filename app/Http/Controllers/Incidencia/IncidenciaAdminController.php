<?php

namespace App\Http\Controllers\Incidencia;

use App\Http\Controllers\Controller;
use App\Models\Comision;
use Illuminate\Http\Request;
use App\Models\Especialidad;
use App\Models\Incidencia;
use App\Models\Tecnico;
use App\Models\Zona;

class IncidenciaAdminController extends Controller
{
    protected IncidenciaService $service;

    public function __construct(IncidenciaService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Incidencia::class);

        $incidencias = $this->service->verTodas();

        $especialdiades = Especialidad::all();

        return view('incidencias.index', compact('incidencias', 'especialdiades'));
    }

    public function create()
    {
        $especialidades = Especialidad::all();
        $zonas = Zona::all();
        $tecnicos = Tecnico::with('especialidad')->where('disponible', true)->get();

        return view('incidencias.create', compact('especialidades', 'zonas', 'tecnicos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'especialidad_id' => 'required|exists:especialidades,id',
            'zona_id' => 'required|exists:zonas,id',
            'descripcion' => 'required|string|max:1000',
            'direccion' => 'required|string|max:255',
            'poblacion' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:5',
            'fecha_servicio' => 'required|date|after:now',
            'tipo_urgencia' => 'required|in:Estándar,Urgente',
            'tecnico_id' => 'nullable|exists:tecnicos,id',
            'cliente_id' => 'required|exists:usuarios,id',
        ]);

        $especialidad = Especialidad::find($data['especialidad_id']);

        $data['cliente_id'] = $cliente->id;
        $data['localizador'] = $this->service->generarLocalizador();
        $data['estado'] = $data['tecnico_id'] ? 'Asignada' : 'Pendiente';
        $data['precio_base'] = $especialidad->precio_base;

        Incidencia::create($data);

        $this->service->crearParaAdmin($data);

        return redirect()->route('incidencias.show', $data['localizador'])->with('success', 'Incidencia creada.');
    }

    public function show(Incidencia $incidencia)
    {
        Gate::authorize('view', $incidencia);

        return view('incidencias.show', compact('incidencia', 'tecnicos'));
    }

    public function edit(Incidencia $incidencia)
    {
        $especialidades = Especialidad::all();
        $zonas = Zona::all();
        $tecnicos = Tecnico::with('especialidad')->get();

        return view('incidencias.edit', compact('incidencia', 'especialidades', 'zonas', 'tecnicos'));
    }

    public function update(Request $request, Incidencia $incidencia)
    {
        Gate::authorize('update', $incidencia);
        $data = $request->validated();

        $incidencia->update($data);

        return redirect()->route('incidencias.show', $incidencia)->with('success', 'Incidencia actualizada exitosamente.');
    }

    public function destroy(Incidencia $incidencia)
    {
        $incidencia->update(['estado' => 'Cancelada']);

        $this->service->cancelar($incidencia);

        return redirect()->route('incidencias.index')->with('success', 'Incidencia cancelada.');
    }

    public function asignarTecnico(Request $request, Incidencia $incidencia)
    {
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
        $request->validate([
            'estado' => 'required|in:Pendiente,Asignada,Finalizada,Cancelada',
        ]);

        $this->service->actualizarEstado($incidencia, $request->estado);

        return back()->with('success', 'Estado actualizado exitosamente.');
    }

    private function generarLocalizador()
    {
        Gate::authorize('viewCalendar', Incidencia::class);

        $incidencias = $this->service->getCalendarDataForUser(Auth::user());

        return view('incidencias.calendario', compact('incidencias'));
    }
}
