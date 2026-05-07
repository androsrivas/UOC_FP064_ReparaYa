<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->timestamp('cancel_at')->nullable()->after('estado');
            $table->foreignId('cancel_by')
                  ->nullable()
                  ->after('cancel_at')
                  ->constrained('usuarios') 
                  ->nullOnDelete();      
        });
    }

    public function down(): void
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->dropForeign(['cancel_by']);
            $table->dropColumn(['cancel_at', 'cancel_by']);
        });
    }
};
