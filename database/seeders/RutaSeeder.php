<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruta;

class RutaSeeder extends Seeder
{
    public function run()
    {
        Ruta::insert([
            [
                'origen' => 'Tegucigalpa',
                'destino' => 'San Pedro Sula',
                'distancia' => 240,
                'duracion_estimada' => 4, // horas o minutos según tu sistema
                'estado' => 1,
            ],
            [
                'origen' => 'Tegucigalpa',
                'destino' => 'La Ceiba',
                'distancia' => 400,
                'duracion_estimada' => 6,
                'estado' => 1,
            ],
            [
                'origen' => 'San Pedro Sula',
                'destino' => 'Choluteca',
                'distancia' => 350,
                'duracion_estimada' => 5,
                'estado' => 1,
            ],
        ]);
    }
}
