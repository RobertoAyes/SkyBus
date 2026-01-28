<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ciudad;

class CiudadesSeeder extends Seeder
{
    public function run(): void
    {
        $ciudades = ['Intibuca', 'El Paraiso', 'Copan', 'Cortez', 'Yoro', 'Choluteca', 'Lempira', 'Santa Barbara', 'Olancho', 'Colon', 'Francisco Morazan', 'Valle', 'Ocotepeque'];

        foreach ($ciudades as $nombre) {
            Ciudad::create(['nombre' => $nombre]);
        }
    }
}
