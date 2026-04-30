<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->string('localizador', 20)->unique();
            $table->foreignId('cliente_id')->constrained('usuarios');
            $table->foreignId('tecnico_id')->nullable()->constrained('tecnicos');
            $table->foreignId('especialidad_id')->constrained('especialidades');
            $table->text('descripcion');
            $table->string('direccion', 255);
            $table->string('poblacion', 255);
            $table->string('codigo_postal', 100);
            $table->dateTime('fecha_servicio');
            $table->enum('tipo_urgencia', ['Estándar', 'Urgente'])->default('Estándar');
            $table->enum('estado', ['Pendiente', 'Asignada', 'Finalizada', 'Cancelada'])->default('Pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
