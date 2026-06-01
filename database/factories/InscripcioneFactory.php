<?php

namespace Database\Factories;

use App\Models\Inscripcione;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InscripcioneFactory extends Factory
{
    protected $model = Inscripcione::class;

    public function definition()
    {
        return [
			'usuario' => $this->faker->name,
			'torneo' => $this->faker->name,
			'estado_pago' => $this->faker->name,
        ];
    }
}
