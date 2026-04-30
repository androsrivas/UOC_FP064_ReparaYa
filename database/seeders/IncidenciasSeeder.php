<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncidenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $localizadores = ['REP-2026-0001', 'REP-2026-0002', 'REP-2026-0003'];
        foreach($localizadores as $i => $loc) {
            DB::table('incidencias')->insert([
                'localizador' => $loc, 
                'cliente_id' => 3,
                'tecnico_id' => 1,
                'especialidad_id' => ($i % 2) + 1,
                'zona_id' => ($i % 4) + 1,
                'descripcion' => 'Incidencia de prueba' . ($i + 1),
                'direccion' => 'Carrer Eixample' . ($i + 1),
                'poblacion' => 'Barcelona',
                'codigo_postal' => '0800' . ($i + 1),
                'fecha_servicio' => now()->addDays($i + 3),
                'tipo_urgencia' => $i === 0 ? 'Urgente' : 'Estándar',
                'estado' => 'Pendiente',
                'created_at' => now(),
                'updated_at' => now(), 
            ]);
        }
    }
}
