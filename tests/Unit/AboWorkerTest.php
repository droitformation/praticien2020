<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Praticien\Categorie\Entities\Categorie as Categorie;
use App\Praticien\Abo\Entities\Abo as Abo;
use App\Praticien\Abo\Entities\Abo_keyword as Abo_keyword;
use App\Praticien\User\Entities\User as User;

class AboWorkerTest extends TestCase
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

    public function testGetDecisionsFromAbo()
    {
        $worker = \App::make('App\Praticien\Abo\Worker\AboWorkerInterface');
        $repos  = \App::make('App\Praticien\Abo\Repo\AboInterface');

        $publication_at = '2020-09-18';

        list($user,$decisions,$categories) = $this->makeDecisionAndAbos($publication_at);

        $results = $repos->getUserAbosForDate($user->id,$publication_at);

        $this->assertEquals(3,$results->count());

        $prepared = $worker->getByAbosCategory($user->id,$publication_at);

        $categorie1 = $categories->shift();
        $categorie2 = $categories->shift();
        $categorie3 = $categories->shift();
        $categorie4 = $categories->shift();

        $this->assertEquals([$categorie1->id, $categorie2->id, $categorie4->id],$prepared->keys()->all());
    }

    /* =================================
   * Make decisions and user
   =================================== */
    public function makeDecisionAndAbos($publication_at)
    {
        $categorie1 = Categorie::factory()->create();
        $categorie2 = Categorie::factory()->create();
        $categorie3 = Categorie::factory()->create();
        $categorie4 = Categorie::factory()->create();

        $data = [
            ['categorie_id' => $categorie1->id, 'texte' => '<div>Accumasa laoreelentesque lorém arcû in quisqué éuismod m44equat liçlà</div>.'], // categorie + keywords
            ['categorie_id' => $categorie2->id, 'texte' => '<div>Dapibus à nul A égét 44 3€ BGFA quisque à nullä dui cctus malet, consequat liçlà</div>.'], // categorie + keywords
            ['categorie_id' => $categorie3->id, 'texte' => '<div>Nul de chose égét 44 3€ quisque à nullä dui cctus malet, consequatà</div>.'],
            ['categorie_id' => $categorie4->id, 'texte' => '<div>Judiciaire égét quisque à nullä dui cctus , consequat liçlà</div>.'] // categorie
        ];

        $make      = new \tests\factories\ObjectFactory();
        $decisions = $make->makeDecisions($publication_at,$data);

        $user = User::factory()->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(), 'cadence' => 'daily',
        ]);

        $abo1 = Abo::factory()->create(['user_id' => $user->id, 'categorie_id' => $categorie1->id]);
        $abo2 = Abo::factory()->create(['user_id' => $user->id, 'categorie_id' => $categorie2->id]);
        $abo3 = Abo::factory()->create(['user_id' => $user->id, 'categorie_id' => $categorie4->id]);

        $keyword = Abo_keyword::factory()->create(['abo_id' => $abo1->id, 'keywords' => '"Accumasa laoreelentesque"']);
        $keyword = Abo_keyword::factory()->create(['abo_id' => $abo2->id, 'keywords' => '"à nul A égét 44",BGFA']);

        return [$user,$decisions,collect([$categorie1, $categorie2, $categorie3, $categorie4])];
    }
}
