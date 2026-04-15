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

            $viajeId = DB::table('viajes')->insertGetId([
                'ruta_id' => $ruta->id,
                'fecha_hora_salida' => now()->addDays(2)->setHour(8),
                'fecha_llegada' => null,
                'precio' => 250,
                'capacidad' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 🔥 CREAR ASIENTOS AUTOMÁTICAMENTE (CRÍTICO)
            for ($i = 1; $i <= 40; $i++) {
                DB::table('asientos')->insert([
                    'viaje_id' => $viajeId,
                    'numero' => 'A' . $i,
                    'ocupado' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
