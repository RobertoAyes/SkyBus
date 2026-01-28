<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EmpresaBus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmpresaBus>
 */
class EmpresaBusFactory extends Factory
{
    protected $model = EmpresaBus::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'propietario' => $this->faker->name,
        ];
    }
}
