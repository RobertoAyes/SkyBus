<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsientosSeeder extends Seeder
{
    public function run(): void
    {
        // obtener todos los viajes
        $viajes = DB::table('viajes')->get();

        if ($viajes->isEmpty()) {
            return;
        }

        foreach ($viajes as $viaje) {

            // limpiar por si re-ejecutas el seeder
            DB::table('asientos')->where('viaje_id', $viaje->id)->delete();

            $fila = 1;
            $letras = ['A', 'B', 'C', 'D'];

            // 10 filas x 4 asientos = 40 asientos
            for ($i = 1; $i <= 10; $i++) {
                foreach ($letras as $letra) {

                    DB::table('asientos')->insert([
                        'viaje_id' => $viaje->id,
                        'numero' => $i . $letra,
                        'ocupado' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
