<?php

namespace Database\Factories;

use App\Praticien\Abo\Entities\Abo;
use Illuminate\Database\Eloquent\Factories\Factory;

class AboFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Praticien\Abo\Entities\Abo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'       => $this->faker->numberBetween(1,10),
            'categorie_id'  => 1,
            'toPublish'     => null,
        ];
    }
}
