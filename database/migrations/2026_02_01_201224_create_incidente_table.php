<?php

//Aquí está la estructura de la tabla de incidentes.

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
        Schema::create('incidentes', function (Blueprint $table) {
            $table->id();  // Crea el id automático de la tabla

            $table->unsignedBigInteger('empleado_id')->nullable(); // Guarda el id del empleado
            $table->string('conductor_nombre');

            $table->string('bus_numero');
            $table->string('ruta');

            $table->string('tipo_incidente');
            $table->text('descripcion');

            $table->timestamp('fecha_hora')->useCurrent(); // Guarda automáticamente la fecha y hora del incidente

            $table->timestamps(); // Guarda automáticamente cuándo se creó y cuándo se editó el registro

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidente');
    }
};
