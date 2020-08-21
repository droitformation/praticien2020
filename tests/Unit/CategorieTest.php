<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategorieTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testMakeCategorieQuery()
    {
        $name = 'Praticien pénal (en général)';

        $worker = \App::make('App\Praticien\Categorie\Worker\CategorieWorkerInterface');

        $query = $worker->makeQuery($name);

        $string  = 'soundex(name)=soundex("'.$name.'")';
        $string .= ' OR soundex(name)=soundex("Praticien pénal (général)")';
        $string .= ' OR soundex(name_de)=soundex("'.$name.'") OR soundex(name_it)=soundex("'.$name.'")';

        $this->assertEquals($string,$query);

        $categorie = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create([
            'name' => $name,
            'name_de' => 'Das nichtgut (en général) de',
            'name_it' => 'El nobueno (en général) it'
        ]);

        $repo  = \App::make('App\Praticien\Categorie\Repo\CategorieInterface');
        $found = $repo->searchByName($name, 'testing');
    }

    public function testMakeCategorieQuery2()
    {
        $name = 'Praticien pénal (en général)';

        $worker = \App::make('App\Praticien\Categorie\Worker\CategorieWorkerInterface');

        $query = $worker->makeQuery($name);

        $string  = 'soundex(name)=soundex("'.$name.'")';
        $string .= ' OR soundex(name)=soundex("Praticien pénal (général)")';
        $string .= ' OR soundex(name_de)=soundex("'.$name.'") OR soundex(name_it)=soundex("'.$name.'")';

        $this->assertEquals($string,$query);

        $categorie = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create([
            'name' => $name,
            'name_de' => 'Das nichtgut (en général) de',
            'name_it' => 'El nobueno (en général) it'
        ]);

        $repo = \App::make('App\Praticien\Categorie\Repo\CategorieInterface');

        $found = $repo->searchByName($name, 'testing');

    }
}
