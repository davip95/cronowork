<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Horario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => null,
            'created_at' => null,
            'updated_at' => null,
            'deleted_at' => null,
            'tipo' => 'empleado',
            'apellidos' => $this->faker->lastName(),
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->streetName() . ' ' . $this->faker->buildingNumber() . ', ' . $this->faker->city(),
            'empresas_id' => function () {
                return Empresa::factory()->create()->id;
            },
            'horarios_id' => function (array $user) {
                return Horario::factory()->create(['empresas_id' => $user['empresas_id']])->id;
            }
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
