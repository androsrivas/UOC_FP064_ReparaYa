<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidades = ['Fontanería', 'Electricidad', 'Carpintería', 'Pintura', 'Climatización', 'Limpieza'];
        foreach($especialidades as $e) {
            DB::table('especialidades')->insert(['nombre_especialidad' => $e, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
