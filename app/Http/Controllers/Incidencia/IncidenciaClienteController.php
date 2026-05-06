<?php

namespace App\Http\Controllers\Incidencia;

use App\Http\Controllers\Controller;
use App\Models\Especialidad;
use App\Models\Incidencia;
use App\Models\Zona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IncidenciaClienteController extends Controller
{
    public function index()
    {
        $incidencias = Incidencia::with(['especialidad', 'tecnico', 'zona'])
            ->where('cliente_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('cliente.incidencias', compact('incidencias'));
    }

    public function create()
    {
        Gate::authorize('create', Incidencia::class);

        $especialidades = Especialidad::all();
        $zonas = Zona::all();

        return view('cliente.nueva-incidencia', compact('especialidades', 'zonas'));
    }

    public function show(Incidencia $incidencia)
    {
        Gate::authorize('view', $incidencia);

        return view('incidencias.show', compact('incidencia'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Incidencia::class);
        
        $data = $request->validate([
            'especialidad_id' => 'required|exists:especialidades,id',
            'zona_id' => 'required|exists:zonas,id',
            'descripcion' => 'required|string|max:1000',
            'direccion' => 'required|string|max:255',
            'poblacion' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:5',
            'fecha_servicio' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $fecha = Carbon::parse($value);
                    $minHoras = $request->tipo_urgencia === 'Urgente' ? 0 : 48;

                    if ($fecha->diffInHours(now(), false) > -$minHoras) {
                        $fail('El servicio estándar necesita al menos 48 horas de antelación.');
                    }
                }
            ],
            'tipo_urgencia' => 'required|in:Estándar,Urgente',
        ]);

        $data['cliente_id'] = auth()->id();
        $data['estado'] = 'Pendiente';
        $data['localizador'] = $this->generarLocalizador();

        Incidencia::create($data);

        return redirect()->route('cliente.incidencias')
            ->with('success', '¡Solicitud creada!. Tu código es ' . $data['localizador'] . '.');
    }

    public function cancel(Incidencia $incidencia) 
    {
        Gate::authorize('cancel', $incidencia);

        if (!$incidencia->puedeCancelar()) {
            return back()->with('error', 
                'No se puede cancelar un servicio con menos de 48 horas de antelación.');
        }

        $incidencia->update(['estado' => 'Cancelada']);

        return redirect()->route('cliente.incidencias')->with('success', 'Incidencia cancelada correctamente.');
    }

    private function generarLocalizador()
    {
        do {
            $codigo = 'REP-' . date('Y') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while( Incidencia::where('localizador', $codigo)->exists() );

        return $codigo;
    }
}
