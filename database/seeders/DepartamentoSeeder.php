<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento;
use App\Models\Lugar;
use App\Models\Comida;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        // Francisco Morazán
        $fm = Departamento::create([
            'nombre' => 'Francisco Morazán',
            'imagen' => 'catalago/img/francisco.jpg'
        ]);

        Lugar::create([
            'departamento_id' => $fm->id,
            'nombre' => 'Cristo del Picacho',
            'imagen' => 'catalago/img/lugares/picacho.jpg'
        ]);

        Lugar::create([
            'departamento_id' => $fm->id,
            'nombre' => 'Parque Nacional La Tigra',
            'imagen' => 'catalago/img/lugares/Parque Nacional La Tigra.jpg'
        ]);

        Comida::create([
            'departamento_id' => $fm->id,
            'nombre' => 'Carne Asada',
            'imagen' => 'catalago/img/comidas/Carne Asada.jpg'
        ]);

        Comida::create([
            'departamento_id' => $fm->id,
            'nombre' => 'Nacatamales',
            'imagen' => 'catalago/img/comidas/Nacatamales.jpg'
        ]);

        // Cortés
        $cortes = Departamento::create([
            'nombre' => 'Cortés',
            'imagen' => 'catalago/img/cortes.jpg'
        ]);

        Lugar::create([
            'departamento_id' => $cortes->id,
            'nombre' => 'Cataratas de Pulhapanzak',
            'imagen' => 'catalago/img/lugares/Cataratas de Pulhapanzak.jpg'
        ]);

        Lugar::create([
            'departamento_id' => $cortes->id,
            'nombre' => 'Fortaleza de San Fernando de Omoa',
            'imagen' => 'catalago/img/lugares/Fortaleza de San Fernando de Omoa.jpg'
        ]);

        Comida::create([
            'departamento_id' => $cortes->id,
            'nombre' => 'Baleadas',
            'imagen' => 'catalago/img/comidas/Baleadas.jpg'
        ]);

        Comida::create([
            'departamento_id' => $cortes->id,
            'nombre' => 'Pollo Chuco',
            'imagen' => 'catalago/img/comidas/Pollo Chuco.jpg'
        ]);

        // Atlántida
        $atlan = Departamento::create([
            'nombre' => 'Atlántida',
            'imagen' => 'catalago/img/atlantida.jpg'
        ]);

        Lugar::create([
            'departamento_id' => $atlan->id,
            'nombre' => 'Parque Nacional Pico Bonito',
            'imagen' => 'catalago/img/lugares/parque pico bonito.jpg'
        ]);

        Lugar::create([
            'departamento_id' => $atlan->id,
            'nombre' => 'Las Cascadas de Zacate',
            'imagen' => 'catalago/img/lugares/cascada zacate.jpg'
        ]);

        Comida::create([
            'departamento_id' => $atlan->id,
            'nombre' => 'Pan de Coco',
            'imagen' => 'catalago/img/comidas/Pan de Coco.jpg'
        ]);

        Comida::create([
            'departamento_id' => $atlan->id,
            'nombre' => 'Tapado Costeño',
            'imagen' => 'catalago/img/comidas/Tapado Costeño.jpg'
        ]);
    }
}
