<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidades = [
            ['nombre_especialidad' => 'Fontanería', 'precio_base' => 80.00],
            ['nombre_especialidad' => 'Electricidad', 'precio_base' => 90.00],
            ['nombre_especialidad' => 'Carpintería', 'precio_base' => 70.00],
            ['nombre_especialidad' => 'Pintura', 'precio_base' => 60.00],
            ['nombre_especialidad' => 'Climatización', 'precio_base' => 65.00],
            ['nombre_especialidad' => 'Limpieza', 'precio_base' => 55.00]
        ];

        foreach ($especialidades as $e) {
            DB::table('especialidades')->insert([
                ...$e, 
                'created_at' => now(), 
                'updated_at' => now()
            ]);
        }
    }
}
