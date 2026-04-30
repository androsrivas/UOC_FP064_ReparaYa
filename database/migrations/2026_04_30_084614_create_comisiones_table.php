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
        Schema::create('comisiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gestora_id')->constrained('gestoras');
            $table->foreignId('incidencia_id')->unique()->constrained('incidencias');
            $table->decimal('importe', 8, 2);
            $table->decimal('precio_base', 8, 2);
            $table->decimal('porcentaje_aplicado', 5, 2);
            $table->unsignedTinyInteger('mes');
            $table->unsignedBigInteger('anyo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comisiones');
    }
};
