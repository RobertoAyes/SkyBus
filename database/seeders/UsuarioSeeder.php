<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Usuario::factory()->count(30)->create();

        // 2. Crear un usuario de prueba específico (útil para el administrador o pruebas)
        // Usamos DB::table si no tienes un modelo, pero si existe, Usuario::create es mejor.
        Usuario::create([
            'nombre_completo' => 'Sindy Escobar Admin',
            'dni' => '1234567890',
            'email' => 'admin@bustrak.test',
            'telefono' => '999888777',
            'password' => Hash::make('password'), // Usar Hash::make para mayor seguridad
        ]);
    }
}

