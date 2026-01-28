<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CanjeBeneficio;

class BeneficiosSeeder extends Seeder
{
    public function run()
    {
        $beneficios = [
            [
                'nombre' => '10% Descuento en próximo viaje',
                'puntos_requeridos' => 50,
                'descripcion' => 'Obtén un 10% de descuento en tu próximo viaje reservado',
                'activo' => true,
            ],
            [
                'nombre' => 'Upgrade a Asiento Premium',
                'puntos_requeridos' => 30,
                'descripcion' => 'Mejora tu asiento a categoría premium en tu próximo viaje',
                'activo' => true,
            ],
            [
                'nombre' => 'Viaje Gratis',
                'puntos_requeridos' => 100,
                'descripcion' => 'Canjea un viaje completamente gratis a cualquier destino',
                'activo' => true,
            ],
            [
                'nombre' => 'Snack de Cortesía',
                'puntos_requeridos' => 15,
                'descripcion' => 'Recibe un snack y bebida de cortesía en tu próximo viaje',
                'activo' => true,
            ],
        ];

        foreach ($beneficios as $beneficio) {
            CanjeBeneficio::create($beneficio);
        }
    }
}
