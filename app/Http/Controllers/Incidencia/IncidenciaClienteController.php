<?php

namespace App\Http\Controllers\Incidencia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Incidencia\StoreIncidenciaRequest;
use App\Models\Especialidad;
use App\Models\Incidencia;
use App\Models\Zona;
use App\Services\IncidenciaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IncidenciaClienteController extends Controller
{
    protected IncidenciaService $incidenciaService;

    public function __construct(IncidenciaService $incidenciaService)
    {
        $this->incidenciaService = $incidenciaService;
    }

    public function index()
    {
        Gate::authorize('viewAny', Incidencia::class);

        $incidencias = $this->incidenciaService->verPorCliente(Auth::id());

        return view('cliente.incidencias', compact('incidencias'));
    }

    public function show(Incidencia $incidencia)
    {
        Gate::authorize('view', $incidencia);

        return view('incidencias.show', compact('incidencia'));
    }

    public function create()
    {
        Gate::authorize('create', Incidencia::class);

        $especialidades = Especialidad::all();
        $zonas = Zona::all();

        return view('incidencias.create', compact('especialidades', 'zonas'));
    }

    public function store(StoreIncidenciaRequest $request)
    {
        Gate::authorize('create', Incidencia::class);
        
        $data = $request->validated();

        $data['cliente_id'] = Auth::id();
        $data['estado'] = 'Pendiente';
        $data['localizador'] = $this->generarLocalizador();

        Incidencia::create($data);

        return redirect()->route('cliente.incidencias')
            ->with('success', '¡Solicitud creada!. Tu código es ' . $data['localizador'] . '.');
    }

    public function cancelar(Incidencia $incidencia) 
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
