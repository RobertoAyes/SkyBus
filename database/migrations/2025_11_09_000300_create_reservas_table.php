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

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('viaje_id')
                ->constrained('viajes')
                ->onDelete('cascade');

            $table->foreignId('asiento_id')
                ->constrained('asientos')
                ->onDelete('cascade');

            $table->string('codigo_reserva')->unique();

            $table->dateTime('fecha_reserva');

            $table->enum('estado', [
                'pendiente',
                'confirmada',
                'cancelada'
            ])->default('pendiente');

            $table->boolean('pagado')->default(false);

            $table->timestamps();

            // 🔥 MEJORA IMPORTANTE: evita doble reserva del mismo asiento en el mismo viaje
            $table->unique(['viaje_id', 'asiento_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
