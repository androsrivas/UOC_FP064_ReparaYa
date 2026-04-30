<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zonas = ['Eixample', 'Gràcia', 'Sarrià', 'Sant Martí'];
        foreach($zonas as $z) {
            DB::table('zonas')->insert(['nombre' => $z, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
