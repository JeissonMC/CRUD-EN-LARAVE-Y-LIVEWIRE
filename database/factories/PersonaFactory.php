<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition()
    {
        return [
			'nombre' => $this->faker->name,
			'apellido' => $this->faker->name,
			'telefono' => $this->faker->name,
			'direccion' => $this->faker->name,
        ];
    }
}
