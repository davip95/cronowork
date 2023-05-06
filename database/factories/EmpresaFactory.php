<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->company(),
            'cif' => $this->faker->unique()->vat(),
            'email' => $this->faker->safeEmail(),
            'direccion' => $this->faker->streetName() . ' ' . $this->faker->buildingNumber() . ', ' . $this->faker->city(),
            'telefono' => $this->faker->phoneNumber(),
            'fecha_alta' => $this->faker->dateTime(),
        ];
    }
}
