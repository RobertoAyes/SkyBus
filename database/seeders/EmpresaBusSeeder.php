<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmpresaBus;

class EmpresaBusSeeder extends Seeder
{
    public function run()
    {

        EmpresaBus::factory()->count(50)->create();
    }
}
