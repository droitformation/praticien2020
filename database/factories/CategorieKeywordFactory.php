<?php

namespace Database\Factories;

use App\Praticien\Categorie\Entities\Categorie_keyword;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieKeywordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Praticien\Categorie\Entities\Categorie_keyword::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'keywords'     => 'Ma categorie',
            'categorie_id' => 1,
        ];
    }
}
