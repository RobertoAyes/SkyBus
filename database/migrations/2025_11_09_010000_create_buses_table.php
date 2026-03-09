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
        // Esta tabla debe existir antes que 'viajes' para que la clave foránea funcione.
        Schema::create('buses', function (Blueprint $table) {
            $table->id();

            // Información básica del bus/vehículo
            $table->string('placa')->unique();
            $table->string('numero_bus')->unique();
            $table->string('modelo');
            $table->integer('capacidad_asientos');
            $table->string('estado')->default('activo'); // Por ejemplo: activo, en mantenimiento, retirado

            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
