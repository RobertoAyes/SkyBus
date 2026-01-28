<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('canje_beneficios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('puntos_requeridos');
            $table->text('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('canje_beneficios');
    }
};
