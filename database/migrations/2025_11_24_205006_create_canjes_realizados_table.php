<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('canjes_realizados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('beneficio_id');
            $table->integer('puntos_usados');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('beneficio_id')->references('id')->on('canje_beneficios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('canjes_realizados');
    }
};
