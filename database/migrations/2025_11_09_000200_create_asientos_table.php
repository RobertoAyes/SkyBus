<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asientos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('viaje_id')
                ->constrained('viajes')
                ->onDelete('cascade');

            $table->string('numero');

            $table->boolean('ocupado')
                ->default(false);

            $table->timestamps();

            // opcional pero MUY recomendado para evitar duplicados
            $table->unique(['viaje_id', 'numero']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asientos');
    }
};
