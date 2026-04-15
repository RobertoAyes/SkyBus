<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario de prueba normal
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'Empleado',
                'estado' => 'activo',
            ]
        );

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@bustrak.com'],
            [
                'name' => 'Administrador del Sistema',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'role' => 'Administrador',
                'estado' => 'activo',
            ]
        );

        // Cliente
        User::firstOrCreate(
            ['email' => 'jose@hn.com'],
            [
                'name' => 'Cliente Predeterminado',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'cliente',
                'estado' => 'activo',
            ]
        );

        // 🔥 ORDEN CORRECTO (CRÍTICO)
        $this->call([
            RutaSeeder::class,
            ViajesSeeder::class,
            AsientosSeeder::class,
        ]);
    }
}
