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
        Schema::create('calificaciones_chofer', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('chofer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reserva_id')->nullable()->constrained('reservas')->nullOnDelete();

            $table->unsignedTinyInteger('estrellas'); // 1–5
            $table->text('comentario')->nullable();

            $table->timestamps();

            $table->unique(['usuario_id', 'chofer_id', 'reserva_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones_chofer');
    }
};
