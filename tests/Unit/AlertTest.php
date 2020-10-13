<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Praticien\Abo\Entities\Abo as Abo;
use App\Praticien\Abo\Entities\Abo_keyword as Abo_keyword;
use App\Praticien\User\Entities\User as User;

class AlertTest extends TestCase
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

    public function testGetDates()
    {
        $today  = \Carbon\Carbon::today();
        $monday = $today->startOfWeek();
        $friday = $today->startOfWeek()->parse('this friday');

        $publication_at = generateDateRange($monday, $friday);

        $alert = \App::make('App\Praticien\Bger\Worker\AlertInterface');
        $alert->setCadence('daily')->setDate($publication_at);

        $date = $alert->getDate();

        $this->assertEquals($friday,$date);
    }

    public function testGetUsersNotAlreadySent()
    {
        $publication_at = \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString();

        list($user,$decisions) = $this->makeDecisionAndAbos($publication_at);

        $alert = \App::make('App\Praticien\Bger\Worker\AlertInterface');
        $alert->setCadence('daily')->setDate($publication_at);

        // Mark it sent
        $alert->sent($user);

        $users = $alert->getUsers();

        $this->assertEquals(0,$users->count());
    }

    public function testGetAbosForUSerAlert()
    {
        $publication_at = \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString();

        $alert = \App::make('App\Praticien\Bger\Worker\AlertInterface');
        $alert->setCadence('daily')->setDate($publication_at);

        list($user,$decisions) = $this->makeDecisionAndAbos($publication_at);

        $results = $alert->getUserAbos($user);

        $decision1 = $decisions->shift();
        $decision2 = $decisions->shift();
        $decision3 = $decisions->shift();

        $row1 = $results->shift();
        $row2 = $results->shift();
        $row3 = $results->shift();

        $this->assertEquals($decision1->id, $row1['decision']->id);
        $this->assertEquals($decision2->id, $row2['decision']->id);
        $this->assertEquals($decision3->id, $row3['decision']->id);

        $this->assertEquals(174, $row1['categorie']);
        $this->assertEquals(175, $row2['categorie']);
        $this->assertEquals(176, $row3['categorie']);

        $this->assertEquals('Accumasa laoreelentesque', $row1['keywords']);
        $this->assertEquals('à nul A égét 44, BGFA', $row2['keywords']);
        $this->assertEquals('', $row3['keywords']);
    }

    /* =================================
     * Make decisions and user
     =================================== */
    public function makeDecisionAndAbos($publication_at)
    {
        $data = [
            ['categorie_id' => 174, 'texte' => '<div>Accumasa laoreelentesque lorém arcû in quisqué éuismod m44equat liçlà</div>.'], // categorie + keywords
            ['categorie_id' => 175, 'texte' => '<div>Dapibus à nul A égét 44 3€ BGFA quisque à nullä dui cctus malet, consequat liçlà</div>.'], // categorie + keywords
            ['categorie_id' => 176, 'texte' => '<div>Nul de chose égét 44 3€ quisque à nullä dui cctus malet, consequatà</div>.'], // categorie
            ['categorie_id' => 177, 'texte' => '<div>Judiciaire égét quisque à nullä dui cctus , consequat liçlà</div>.']
        ];

        $make      = new \tests\factories\ObjectFactory();
        $decisions = $make->makeDecisions($publication_at,$data);

        $user = User::factory()->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(), 'cadence' => 'daily',
        ]);

        $abo1 = Abo::factory()->create(['user_id' => $user->id, 'categorie_id' => 174]);
        $abo2 = Abo::factory()->create(['user_id' => $user->id, 'categorie_id' => 175]);
        $abo3 = Abo::factory()->create(['user_id' => $user->id, 'categorie_id' => 176]);

        $keyword = Abo_keyword::factory()->create(['abo_id' => $abo1->id, 'keywords' => '"Accumasa laoreelentesque"']);
        $keyword = Abo_keyword::factory()->create(['abo_id' => $abo2->id, 'keywords' => '"à nul A égét 44",BGFA']);

        return [$user,$decisions];
    }
}
