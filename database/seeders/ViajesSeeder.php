<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViajesSeeder extends Seeder
{
    public function run(): void
    {
        $rutas = DB::table('rutas')->get();

        if ($rutas->isEmpty()) {
            return;
        }

        foreach ($rutas as $ruta) {

            // 🔥 CREAR VARIOS VIAJES (NO SOLO 1)
            for ($d = 0; $d < 5; $d++) {

                $viajeId = DB::table('viajes')->insertGetId([
                    'ruta_id' => $ruta->id,
                    'fecha_hora_salida' => now()->addDays($d)->setTime(8, 0, 0),
                    'fecha_llegada' => now()->addDays($d)->setTime(12, 0, 0),
                    'precio' => 250,
                    'capacidad' => 40,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 🔥 ASIENTOS CORRECTOS (1A, 1B, etc.)
                $filas = 10;
                $columnas = ['A','B','C','D'];

                for ($f = 1; $f <= $filas; $f++) {
                    foreach ($columnas as $c) {
                        DB::table('asientos')->insert([
                            'viaje_id' => $viajeId,
                            'numero' => $f . $c,
                            'ocupado' => 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
