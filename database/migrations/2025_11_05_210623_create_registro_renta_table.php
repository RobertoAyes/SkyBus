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
        Schema::create('registro_rentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->string('nombre_completo'); // NUEVO CAMPO
            $table->enum('tipo_evento', ['familiar', 'campamento', 'excursion', 'educativo', 'empresarial']);
            $table->string('destino');
            $table->string('punto_partida');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('num_pasajeros_confirmados')->nullable();
            $table->integer('num_pasajeros_estimados')->nullable();
            $table->decimal('tarifa', 10, 2)->default(0);
            $table->decimal('descuento', 10, 2)->nullable();
            $table->decimal('total_tarifa',10, 2)->nullable();
            $table->string('codigo_renta')->unique();
            $table->enum('estado', ['cotizado','confirmado','en_ruta','completado','cancelado'])->default('cotizado');
            $table->decimal('anticipo', 10, 2)->default(0);
            $table->time('hora_salida')->nullable();
            $table->time('hora_retorno')->nullable();
            $table->decimal('penalizacion', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_rentas');
    }
};
