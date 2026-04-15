<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ruta_id')
                ->constrained('rutas')
                ->onDelete('cascade');

            $table->dateTime('fecha_hora_salida');

            $table->dateTime('fecha_llegada')
                ->nullable();

            $table->decimal('precio', 10, 2);

            $table->integer('capacidad')
                ->default(40);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
