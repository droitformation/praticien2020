<?php

namespace Database\Factories;

use App\Praticien\Decision\Entities\Decision;
use Illuminate\Database\Eloquent\Factories\Factory;

class DecisionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Praticien\Decision\Entities\Decision::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'publication_at' => $this->faker->dateTime,
            'decision_at'    => $this->faker->dateTime,
            'categorie_id'   => 1,
            'remarque'       => $this->faker->word,
            'numero'         => '3A_23/2017',
            'link'           => $this->faker->url,
            'texte'          => $this->faker->text(200),
            'langue'         => 1,
            'publish'        => null,
            'updated'        => null,
            'created_at'      => \Carbon\Carbon::now(),
            'updated_at'      => \Carbon\Carbon::now()
        ];
    }
}
