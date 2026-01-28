<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;
use App\Models\Ciudad;
use App\Models\Viaje;
use App\Models\Asiento;
use Illuminate\Support\Carbon;

class ViajesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear un bus de prueba si no existe
        $bus = Bus::firstOrCreate(
            ['placa' => 'AAA-001'],
            [
                'modelo' => 'Volvo 9700',
                'capacidad_asientos' => 40,
                'numero_bus' => Bus::max('numero_bus') + 1 // obligatorio

            ]
        );

        // Traer todas las ciudades
        $ciudades = Ciudad::all();

        if ($ciudades->count() < 2) {
            $this->command->info("Necesitas al menos 2 ciudades para crear viajes.");
            return;
        }

        // Crear viajes aleatorios entre ciudades
        foreach ($ciudades as $origen) {
            foreach ($ciudades as $destino) {
                if ($origen->id !== $destino->id) {
                    $viaje = Viaje::create([
                        'ciudad_origen_id' => $origen->id,
                        'ciudad_destino_id' => $destino->id,
                        'bus_id' => $bus->id,
                        'fecha_hora_salida' => Carbon::now()->addDays(rand(1, 7))->setTime(rand(5, 22), 0),
                        'asientos_totales' => 10, // o $bus->capacidad_asientos
                    ]);

                    // Crear asientos
                    for ($i = 1; $i <= 10; $i++) {
                        Asiento::create([
                            'viaje_id' => $viaje->id,
                            'numero_asiento' => $i,
                            'disponible' => true,
                        ]);
                    }
                }
            }
        }
        $this->command->info("Seeder de viajes y asientos ejecutado correctamente.");
    }
}
