<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserInsertTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testConvertUser()
    {
        $user = $this->makeDataWordpressUser();

        $expected = [
            'id'            => 321,
            'first_name'    => 'Jane',
            'last_name'     => 'Doe',
            'email'         => 'hello@domain.ch',
            'password'      => 12345678,
            'adresse'       => 'Rue du test 123',
            'npa'           => '1234' ,
            'ville'         => 'Manhattan',
            'active_until'  => '2020-12-31',
            'cadence'       => 'all', // weekly, daily
            'abos' => [
                [
                    'categorie_id' => 2,
                    'keywords' => ['test1, test2'],
                    'isPub' => 1
                ]
            ]
        ];

        $converted = \App\Praticien\Wordpress\Convert\User::convert($user);

        $this->assertEquals($expected,$converted);
    }

   public function testInsertUser()
    {
        $user = $this->makeDataWordpressUser();

        $converted = \App\Praticien\Wordpress\Convert\User::convert($user);

        $repo = \App::make('App\Praticien\User\Repo\UserInterface');
        $repo->create($converted);

        $this->assertDatabaseHas('users', [
            'id'            => 321,
            'first_name'    => 'Jane',
            'last_name'     => 'Doe',
            'email'         => 'hello@domain.ch',
            'password'      => 12345678,
            'adresse'       => 'Rue du test 123',
            'npa'           => '1234' ,
            'ville'         => 'Manhattan',
            'active_until'  => '2020-12-31',
            'cadence'       => 'all',
        ]);
    }

    public function makeDataWordpressUser(){
        $user = new \stdClass();
        $user->ID            = 321;
        $user->user_email    = 'hello@domain.ch';
        $user->user_pass     = 12345678;
        $user->user_nicename = 'hello';

        $metas = [
            'first_name'      => 'Jane',
            'last_name'       => 'Doe',
            'rythme_abo'      => 'all',
            'adresse'         => 'Rue du test 123',
            'npa'             => '1234' ,
            'ville'           => 'Manhattan',
            'date_abo_active' => '2020-12-31',
        ];

        $items = [];

        foreach ($metas as $key => $m){
            $meta = new \stdClass();
            $meta->meta_key   = $key;
            $meta->meta_value = $m;

            $items[] = $meta;
        }

        $user->meta = collect($items);

        $abo = new \stdClass();
        $abo->refUser      = 321;
        $abo->refCategorie = 2;
        $abo->keywords     = 'test1, test2';

        $pub = new \stdClass();
        $pub->refUser      = 321;
        $pub->refCategorie = 2;
        $pub->isPub        = 1;

        $user->abos = collect([$abo]);
        $user->published = collect([$pub]);

        return $user;
    }
}
