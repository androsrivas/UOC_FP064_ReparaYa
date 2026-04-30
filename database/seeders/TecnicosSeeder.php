<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TecnicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tecnicos')->insert([
            'usuario_id' => 2, 'nombre_completo' => 'Joan Técnico', 'especialidad_id' => 1, 'disponible' => true, 'created_at' => now(), 'updated_at' => now()
        ]);
    }
}
