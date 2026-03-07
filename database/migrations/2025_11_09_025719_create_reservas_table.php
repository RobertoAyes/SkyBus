<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();

            // Relación con usuarios (tu tabla de perfiles)
            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->onDelete('cascade');

            // Relación con viajes
            $table->foreignId('viaje_id')
                ->constrained('viajes')
                ->onDelete('cascade');

            // 🔥 Relación con asientos (la que te faltaba)
            $table->foreignId('asiento_id')
                ->constrained('asientos')
                ->onDelete('cascade');

            $table->string('codigo_reserva')->unique();
            $table->dateTime('fecha_reserva');
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
