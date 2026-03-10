<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incidentes', function (Blueprint $table) {

            // Ubicación donde ocurrió la falla
            $table->string('ubicacion')->nullable();

            // Nivel de gravedad de la falla
            $table->enum('nivel_gravedad', ['baja', 'media', 'alta', 'critica'])->nullable();

            // Estado del reporte
            $table->enum('estado', ['pendiente', 'en_proceso', 'resuelto'])
                ->default('pendiente');
        });
    }

    public function down(): void
    {
        Schema::table('incidentes', function (Blueprint $table) {

            // Si se revierte la migración, se eliminan estas columnas
            $table->dropColumn('ubicacion');
            $table->dropColumn('nivel_gravedad');
            $table->dropColumn('estado');

        });
    }
};
