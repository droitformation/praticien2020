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

    public function testCategorieDispatch()
    {
        $worker = new \App\Praticien\Categorie\Worker\CategorieWorker(\App::make('App\Praticien\Decision\Repo\DecisionInterface'));

        $publication_at = \Carbon\Carbon::today()->toDateString();

        $categorie1 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();
        $categorie2 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();
        $categorie3 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();
        $categorie4 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();

        $decision1 = factory(\App\Praticien\Decision\Entities\Decision::class)->create([
            'publication_at' => $publication_at,
            'categorie_id'   => $categorie4->id,
            'texte'          => '<div>Dapibus ante accumasa laoreelentesque lorém arcû in BGFA éuismod metus enim imperdiet egéstat ligula àc voluptà torquent sapien</div>.'
        ]);

        $decision2 = factory(\App\Praticien\Decision\Entities\Decision::class)->create([
            'publication_at' => $publication_at,
            'categorie_id'   => $categorie4->id,
            'texte'          => '<div>Dapibus anuismod Procédure enim imperdiet egéstat ligula àc voluptà torquent sapien placérat liçlà à, nullä ultrices consequat liçlà</div>.'
        ]);

        $decision3 = factory(\App\Praticien\Decision\Entities\Decision::class)->create([
            'publication_at' => $publication_at,
            'categorie_id'   => $categorie4->id,
            'texte'          => '<div> Ante accumasa laoreelentesque lorém arcû in quisqué éuismod metus  egéstat ligula àc voluptà torquent sapien placérat, nullä ultrices</div>.'
        ]);

        $results = $worker->find($publication_at);

        $this->assertEquals(2,$results->flatten(1)->count());

        $decisions = $worker->process($publication_at);

        $d_1 = $decision1->fresh();
        $d_2 = $decision2->fresh();

        $this->assertTrue($d_1->other_categories->contains(244));
        $this->assertTrue($d_2->other_categories->contains(207));
    }
}
