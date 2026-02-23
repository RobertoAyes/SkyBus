<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('itinerarios_chofer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chofer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ruta_id')->constrained('rutas')->onDelete('cascade');
            $table->dateTime('fecha')->nullable(); // datetime para fecha + hora
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itinerarios_chofer');
    }
};
