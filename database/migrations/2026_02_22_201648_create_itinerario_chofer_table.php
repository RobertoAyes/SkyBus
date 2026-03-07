<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itinerario_chofer', function (Blueprint $table) {
            $table->id();

            // Apuntando a la tabla users, que es donde están los choferes
            $table->foreignId('chofer_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('ruta_id')->constrained('rutas')->cascadeOnDelete();

            $table->dateTime('fecha')->nullable()->change();

            $table->timestamps();

            $table->unique(['chofer_id', 'ruta_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itinerario_chofer');
    }
};
