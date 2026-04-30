<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GestorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gestoras')->insert([
            'nombre' => 'Gestora BCN SL', 'email' => 'gestora1@reparaya.com', 'telefono' => '600000003', 'porcentaje_comision' => 10.00, 'usuario_id' => 4, 'activa' => true, 'created_at' => now(), 'updated_at' => now()
        ]);
    }
}
