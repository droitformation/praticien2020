<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Praticien\User\Entities\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'adresse'    => $faker->address,
        'npa'        => $faker->postcode,
        'ville'      => $faker->city,
    ];
});

$factory->define(App\Praticien\Code\Entities\Arret::class, function (Faker $faker) {

    return [
        'code'      => Str::random(8),
        'valid_at'  => \Carbon\Carbon::tomorrow()->toDateString(),
        'user_id'   => null,
    ];
});

