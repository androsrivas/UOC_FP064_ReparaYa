<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            ['nombre' => 'Admin ReparaYa', 'email' => 'admin1@reparaya.com', 'password' => bcrypt('admin123'), 'rol' => 'admin', 'telefono' => '600000000', 'created_at' => now(), 'updated_at' => now()],

            ['nombre' => 'Joan Técnico', 'email' => 'tecnico1@reparaya.com', 'password' => bcrypt('tecnico123'), 'rol' => 'tecnico', 'telefono' => '600000001', 'created_at' => now(), 'updated_at' => now()],

            ['nombre' => 'Maria Cliente', 'email' => 'cliente1@reparaya.com', 'password' => bcrypt('cliente123'), 'rol' => 'particular', 'telefono' => '600000002', 'created_at' => now(), 'updated_at' => now()],

            ['nombre' => 'Gestora BCN', 'email' => 'gestora1@reparaya.com', 'password' => bcrypt('gestora123'), 'rol' => 'gestora', 'telefono' => '600000003', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
