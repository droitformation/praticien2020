<?php

namespace Database\Factories;

use App\Praticien\Arret\Entities\Arret;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArretFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Praticien\Arret\Entities\Arret::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'published_at' => $this->faker->dateTime,
            'title'        => $this->faker->word,
            'status'       => 'publish',
            'slug'         => str_slug($this->faker->word),
            'content'      => $this->faker->text(200),
            'lang'         => 1,
            'created_at'   => \Carbon\Carbon::now(),
            'updated_at'   => \Carbon\Carbon::now()
        ];
    }
}
