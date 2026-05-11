<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTecnicoRequest;
use App\Services\TecnicoService;
use App\Models\Especialidad;
use App\Models\Tecnico;
use App\Models\User;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    protected TecnicoService $service;

    public function __construct(TecnicoService $service) 
    {
        $this->service = $service;
    }

    public function index()
    {
        $tecnicos = $this->service->verTodos();

        $especialidades = Especialidad::all();

        return view('tecnicos.index', compact('tecnicos', 'especialidades'));
    }

    
    public function create()
    {
        $especialidades = Especialidad::all();

        return view('tecnicos.create', compact('especialidades'));
    }

    public function store(StoreTecnicoRequest $request)
    {
        $userData = $request->only(['nombre', 'email', 'pasword']);
        $tecnicoData =  [
            'nombre_completo' => $request->nombre_completo ?? $request->nombre,
            'especialidad_id' => $request->especialidad_id,
            'telefono' => $request->telefono,
            'disponible' => $request->boolean('disponible', true),
        ];

        $tecnico = $this->service->crearConUsuario($userData, $tecnicoData);

        return redirect()->route('tecnicos.show', $tecnico)
            ->with('success', 'Técnico creado.');

    }

    public function show(Tecnico $tecnico)
    {
        $tecnico->load(['usuario_id', 'especialidad']);
        $usuario = User::with('usuario_id')->get();
        $especialidad = Especialidad::with('especialidad')->get();

        return view('tecnicos.show', compact('usuario', 'especialidad'));
    }

    public function edit(Tecnico $tecnico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
