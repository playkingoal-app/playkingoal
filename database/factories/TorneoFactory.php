<?php

namespace Database\Factories;

use App\Models\Torneo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TorneoFactory extends Factory
{
    protected $model = Torneo::class;

    public function definition()
    {
        return [
			'nombre_torneo' => $this->faker->name,
			'precio' => $this->faker->name,
			'fecha_inicio' => $this->faker->name,
			'fecha_fin' => $this->faker->name,
			'activo' => $this->faker->name,
        ];
    }
}
