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
        Schema::create('calificacions', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('reserva_id')->unique();

            $table->unsignedBigInteger('usuario_id');


            $table->tinyInteger('estrellas');


            $table->text('comentario')->nullable();

            $table->timestamps();


            $table->foreign('reserva_id')
                ->references('id')->on('reservas')
                ->onDelete('cascade');

            $table->foreign('usuario_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacions');
    }
};
