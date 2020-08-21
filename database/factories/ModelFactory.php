<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'       => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'adresse'        => $faker->address,
        'npa'            => $faker->postcode,
        'ville'          => $faker->city,
        'active_until'   => null,
        'cadence'        => 'daily',
    ];
});

$factory->define(App\Praticien\Code\Entities\Code::class, function (Faker $faker) {
    return [
        'code'      => Str::random(8),
        'valid_at'  => \Carbon\Carbon::tomorrow()->toDateString(),
        'user_id'   => null,
    ];
});

$factory->define(App\Praticien\Decision\Entities\Decision::class, function (Faker $faker) {
    return [
        'publication_at' => $faker->dateTime,
        'decision_at'    => $faker->dateTime,
        'categorie_id'   => 1,
        'remarque'       => $faker->word,
        'numero'         => '3A_23/2017',
        'link'           => $faker->url,
        'texte'          => $faker->text(200),
        'langue'         => 1,
        'publish'        => null,
        'updated'        => null,
        'created_at'      => \Carbon\Carbon::now(),
        'updated_at'      => \Carbon\Carbon::now()
    ];
});

$factory->define(App\Praticien\Categorie\Entities\Categorie::class, function (Faker $faker) {
    return [
        'name'      => 'Ma categorie',
        'name_de'   => 'Ma categorie all',
        'name_it'   => 'Ma categorie it',
        'parent_id' => 0,
        'rang'      => 0,
        'general'   => null,
    ];
});

$factory->define(App\Praticien\Abo\Entities\Abo::class, function (Faker $faker) {
    return [
        'user_id'      => 1,
        'categorie_id' => 1,
        'keywords'     => 'words',
    ];
});

$factory->define(App\Praticien\Abo\Entities\Abo::class, function (Faker $faker) {

    $categorie = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();

    return [
        'user_id'       => $faker->numberBetween(1,10),
        'categorie_id'  => $categorie->id,
        'keywords'      => $faker->word,
    ];
});
