<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('paradas_itinerario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerario_chofer_id')
                ->constrained('itinerarios_chofer')
                ->onDelete('cascade');
            $table->string('lugar_parada');
            $table->integer('tiempo_parada'); // minutos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paradas_itinerario');
    }
};
