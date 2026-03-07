<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('itinerarios_chofer', function (Blueprint $table) {
            $table->dateTime('fecha')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('itinerarios_chofer', function (Blueprint $table) {
            $table->date('fecha')->nullable()->change();
        });
    }
};
