<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class HorarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descripcion' => $this->faker->sentence(3),
            'fecha_inicio' => '2023-06-01',
            'fecha_fin' => '2023-09-30',
            'empresas_id' => function () {
                return Empresa::factory()->create()->id;
            },
        ];
    }
}
