<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Empleado;

class EmpleadoFactory extends Factory
{
    protected $model = Empleado::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'dni' => $this->faker->unique()->numerify('#############'),
            'cargo' => $this->faker->randomElement(['Chofer', 'Aseo', 'Servicio al cliente', 'Gerente de área', 'Técnico IT']),
            'fecha_ingreso' => $this->faker->date('Y-m-d', '2025-12-31'),
            'estado' => $this->faker->randomElement(['Activo', 'Inactivo']),
            'rol' => $this->faker->randomElement(['Empleado', 'Administrador']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
