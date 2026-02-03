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
        Schema::create('incidentes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->string('conductor_nombre');

            $table->string('bus_numero');
            $table->string('ruta');

            $table->string('tipo_incidente');
            $table->text('descripcion');

            $table->timestamp('fecha_hora')->useCurrent();

            $table->timestamps();
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
