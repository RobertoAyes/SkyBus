<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('itinerarios_chofer', function (Blueprint $table) {
            $table->timestamp('hora_salida')->nullable()->after('fecha');
            $table->timestamp('hora_llegada')->nullable()->after('hora_salida');
            $table->string('estado_viaje')->default('Pendiente')->after('hora_llegada');
        });
    }

    public function down(): void
    {
        Schema::table('itinerarios_chofer', function (Blueprint $table) {
            $table->dropColumn(['hora_salida', 'hora_llegada', 'estado_viaje']);
        });
    }
};
