<?php

namespace Database\Factories;

use App\Praticien\Theme\Entities\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThemeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Praticien\Theme\Entities\Theme::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      => 'Ma categorie',
            'slug'      => 'ma-categorie',
            'parent_id' => 0,
        ];
    }
}
