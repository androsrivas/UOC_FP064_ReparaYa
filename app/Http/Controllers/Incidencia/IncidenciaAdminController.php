<?php

namespace App\Http\Controllers\Incidencia;

use App\Http\Controllers\Controller;
use App\Models\Comision;
use Illuminate\Http\Request;
use App\Models\Especialidad;
use App\Models\Incidencia;
use App\Models\Tecnico;
use App\Models\User;
use App\Models\Zona;

class IncidenciaAdminController extends Controller
{
    public function index(Request $request)
    {
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
        $clientes = User::select('email')->get();
        $especialidades = Especialidad::all();
        $zonas = Zona::all();
        $tecnicos = Tecnico::with('especialidad')->where('disponible', true)->get();

        return view('incidencias.create', compact('clientes', 'especialidades', 'zonas', 'tecnicos'));
    }

    public function store(Request $request)
    {
        // dd( $request->all() );

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
            'email' => 'required|email|exists:usuarios,email',
            'precio_base' => 'required|numeric|min:0',
        ]);

        $cliente = User::where('email', $data['email'])->first();
        $especialidad = Especialidad::find($data['especialidad_id']);

        $data['cliente_id'] = $cliente->id;
        $data['localizador'] = $this->generarLocalizador();
        $data['estado'] = $data['tecnico_id'] ? 'Asignada' : 'Pendiente';
        $data['precio_base'] = $especialidad->precio_base;
        
        unset($data['email']);

        Incidencia::create($data);

        return redirect()->route('incidencias.index')->with('success', 'Incidencia creada exitosamente.');
    }

    public function show(Incidencia $incidencia)
    {
        $incidencia->load(['cliente', 'tecnico.especialidad', 'especialidad', 'zona', 'comision']);
        $tecnicos = Tecnico::with('especialidad')->get();

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
        $data = $request->validate([
            'especialidad_id' => 'required|exists:especialidades,id',
            'zona_id' => 'required|exists:zonas,id',
            'descripcion' => 'required|string|max:1000',
            'direccion' => 'required|string|max:255',
            'poblacion' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:5',
            'fecha_servicio' => 'required|date|after:now',
            'tipo_urgencia' => 'required|in:Estándar,Urgente',
            'precio_base' => 'required|numeric|min:0',
            'tecnico_id' => 'nullable|exists:tecnicos,id',
        ]);

        $incidencia->update($data);

        return redirect()->route('incidencias.show', $incidencia)->with('success', 'Incidencia actualizada exitosamente.');
    }

    public function destroy(Incidencia $incidencia)
    {
        $incidencia->update(['estado' => 'Cancelada']);

        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada exitosamente.');
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

        $incidencia->update(['estado' => $request->estado]);

        if ($request->estado === 'Finalizada' && $incidencia->empresa_gestora_id) {
            $this->generarComision($incidencia);
        }

        return back()->with('success', 'Estado actualizado exitosamente.');
    }

    private function generarLocalizador()
    {
        do {
            $codigo = 'REP-' . date('Y') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while( Incidencia::where('localizador', $codigo)->exists() );

        return $codigo;
    }

    private function generarComision(Incidencia $incidencia)
    {
        $gestora = $incidencia->gestora;

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

    public function calendario() 
    {
        $incidencias = Incidencia::with(['cliente', 'tecnico', 'especialidad'])
            ->whereNotIn('estado', ['Cancelada'])
            ->get()
            ->map(fn($inc) => [
                'id' => $inc->id,
                'localizador' => $inc->localizador,
                'cliente' => $inc->cliente->nombre,
                'especialidad' => $inc->especialidad->nombre_especialidad,
                'fecha_servicio' => $inc->fecha_servicio->toIso8601String(),
                'fecha_servicio_fmt' => $inc->fecha_servicio->format('d/m/Y H:i'),
                'direccion' => $inc->direccion,
                'descripcion' => $inc->descripcion,
                'tipo_urgencia' => $inc->tipo_urgencia,
                'estado' => $inc->estado,
                'tecnico' => $inc->tecnico?->nombre_completo,
                'url_detall' => route('incidencias.show', $inc->id),    
            ]);

        return view('incidencias.calendario', compact('incidencias'));
    }
}
