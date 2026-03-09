<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();

            // Define el destino (por ejemplo, id de ciudad o texto)
            $table->string('destino');

            // Define el origen
            $table->string('origen');

            // Información de la ruta o el vehículo
            $table->foreignId('bus_id')->constrained('buses'); // Asume que tienes una tabla 'buses'
            $table->dateTime('fecha_salida');
            $table->dateTime('fecha_llegada');
            $table->decimal('precio', 8, 2);
            $table->integer('capacidad_maxima');

            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
