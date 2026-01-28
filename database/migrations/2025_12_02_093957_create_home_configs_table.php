<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_configs', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->text('subtitulo')->nullable();
            $table->string('texto_boton')->nullable();
            $table->string('link_boton')->nullable();
            $table->string('imagen_banner')->nullable();
            $table->string('beneficios_titulo')->nullable();
            $table->text('beneficios_text')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('home_configs');
    }
};
