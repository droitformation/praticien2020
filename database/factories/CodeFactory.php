<?php

namespace Database\Factories;

use App\Praticien\Code\Entities\Code;
use Illuminate\Database\Eloquent\Factories\Factory;

class CodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Praticien\Code\Entities\Code::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code'      => \Str::random(8),
            'valid_at'  => \Carbon\Carbon::tomorrow()->toDateString(),
            'user_id'   => null,
        ];
    }
}
