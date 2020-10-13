<?php

namespace Database\Factories;

use App\Praticien\Abo\Entities\Abo_keyword;
use Illuminate\Database\Eloquent\Factories\Factory;

class AboKeywordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Praticien\Abo\Entities\Abo_keyword::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'abo_id'   => 1,
            'keywords' => $this->faker->words(5)
        ];
    }
}
