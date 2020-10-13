<?php

namespace Database\Factories;

use App\Praticien\Categorie\Entities\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Praticien\Categorie\Entities\Categorie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      => 'Ma categorie',
            'name_de'   => 'Ma categorie all',
            'name_it'   => 'Ma categorie it',
            'parent_id' => 0,
            'rang'      => 0,
            'general'   => null,
        ];
    }
}
