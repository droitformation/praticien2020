<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAboTest extends TestCase
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

    public function testGetUserIsValid()
    {
        $user = factory(\App\Praticien\User\Entities\User::class)->create(['active_until' => \Carbon\Carbon::today()->addMonth()->toDateTimeString(),'cadence' => 'daily']);

        $this->assertTrue($user->valid);
    }

    public function testGetUserIsNotValid()
    {
        $user = factory(\App\Praticien\User\Entities\User::class)->create(['active_until' => \Carbon\Carbon::today()->subMonth()->toDateTimeString(),'cadence' => 'daily']);

        $this->assertFalse($user->valid);
    }

    public function testGetUserReValidate()
    {
        $code = factory(\App\Praticien\Code\Entities\Code::class)->create();
        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->subMonth()->toDateTimeString(),
            'cadence' => 'daily'
        ]);

        $response = $this->post('login', ['email' => $user->email, 'password' => 'password']);
        $response->assertRedirect('expired');

        $response = $this->post('activate', ['email' => $user->email, 'password' => 'password','code' => $code->code]);

        $response->assertRedirect('home');
    }

    public function testGetUserReValidateInvalidCode()
    {
        $code = factory(\App\Praticien\Code\Entities\Code::class)->create(['valid_at'=> \Carbon\Carbon::yesterday()->toDateString()]);

        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->subMonth()->toDateTimeString(), 'cadence' => 'daily',
        ]);

        $response = $this->post('login', ['email' => $user->email, 'password' => 'password']);
        $response->assertRedirect('expired');

        $response = $this->post('activate', ['email' => $user->email, 'password' => 'password','code' => $code->code]);
        $response->assertRedirect('expired');
    }

    public function testGetUsersForCadence()
    {
        $repo = \App::make('App\Praticien\User\Repo\UserInterface');

        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->addMonth()->toDateTimeString(), 'cadence' => 'daily',
        ]);

        // getByCadence wants user with abos ;)
        $abo    = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id' => $user->id, 'categorie_id' => 174]);
        $keyword = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo->id, 'keywords' => '"Accumasa laoreelentesque"']);

        $users = $repo->getByCadence('daily');

        $this->assertEquals(1,$users->count());
    }

    public function testGetUsersForCadenceNoUsers()
    {
        $repo = \App::make('App\Praticien\User\Repo\UserInterface');

        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(), 'cadence'  => 'weekly',
        ]);

        $abo    = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id' => $user->id, 'categorie_id' => 174]);
        $keyword = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo->id, 'keywords' => '"Accumasa laoreelentesque"']);

        $users = $repo->getByCadence('daily');

        $this->assertEquals(0,$users->count());
    }

    public function testGetUsersForCadenceNoUsersWithAbos()
    {
        $repo = \App::make('App\Praticien\User\Repo\UserInterface');

        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(), 'cadence' => 'daily',
        ]);

        $users = $repo->getByCadence('daily');
        $all   = $repo->getAll();

        $this->assertEquals(0,$users->count());
        $this->assertEquals(1,$all->count());
    }

    public function testGetUsersForCadenceNoActiveUsers()
    {
        $repo = \App::make('App\Praticien\User\Repo\UserInterface');

        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->subMonth()->toDateTimeString(), 'cadence' => 'daily',
        ]);

        $users = $repo->getByCadence('daily');
        $all = $repo->getAll();

        $this->assertEquals(0,$users->count());
        $this->assertEquals(1,$all->count());
    }

    /**
     * @runTestsInSeparateProcesses
     */
    public function testGetAbosOfUser()
    {
        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(),
            'cadence'      => 'daily',
        ]);

        $categorie1 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create(['name' => 'test 1']);
        $categorie2 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create(['name' => 'test 1']);

        $abo1    = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id' => $user->id, 'categorie_id' => $categorie1->id]);
        $keyword = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo1->id, 'keywords' => '"Assurance de Protection Juridique SA"']);

        $abo2    = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id' => $user->id, 'categorie_id' => $categorie2->id, 'toPublish' => 1]);
        $keyword = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo2->id, 'keywords' => '"recours en matière civile"']);
        $keyword = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo2->id, 'keywords' => '"canton de Genève"']);

        $expect = collect([
            $categorie1->id => ['title' => $categorie1->name, 'keywords' => collect([
                collect(['Assurance de Protection Juridique SA'])
            ]), 'published' => null],
            $categorie2->id => ['title' => $categorie2->name, 'keywords' => collect([
                collect(['recours en matière civile']),collect(['canton de Genève'])
            ]), 'published' => 1],
        ]);



        $this->assertEquals($expect->toArray(),$user->abonnements->toArray());
    }

    public function testGetUsers()
    {
        $publication_at = \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString();

        $categorie1 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();
        $categorie2 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();
        $categorie3 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();
        $categorie4 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();

        $data = [
           ['categorie_id' => $categorie1->id, 'texte' => '<div>Accumasa laoreelentesque lorém arcû in quisqué éuismod m44equat liçlà</div>.'],// categorie + keywords
           ['categorie_id' => $categorie2->id, 'texte' => '<div>Dapibus à nul A égét 44 3€ BGFA quisque à nullä dui cctus malet, consequat liçlà</div>.'],// categorie + keywords
           ['categorie_id' => $categorie3->id, 'texte' => '<div>Nul de chose égét 44 3€ quisque à nullä dui cctus malet, consequatà</div>.'],// categorie
           ['categorie_id' => $categorie4->id, 'texte' => '<div>Judiciaire égét quisque à nullä dui cctus , consequat liçlà</div>.']
        ];

        $make      = new \tests\factories\ObjectFactory();
        $decisions = $make->makeDecisions($publication_at,$data);

        $user = factory(\App\Praticien\User\Entities\User::class)->create([
           'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(), 'cadence' => 'daily',
        ]);

        $abo3 = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id'  => $user->id, 'categorie_id' => $categorie3->id]);
        $abo1 = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id'  => $user->id, 'categorie_id' => $categorie1->id]);
        $abo2 = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id'  => $user->id, 'categorie_id' => $categorie2->id]);

        $keyword3 = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo1->id, 'keywords' => '"other things']);
        $keyword1 = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo1->id, 'keywords' => '"Accumasa laoreelentesque"']);
        $keyword2 = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo2->id, 'keywords' => '"à nul A égét 44",BGFA']);

        $this->assertTrue($user->abonnements->keys()->contains($categorie1->id));
        $this->assertTrue($user->abonnements->keys()->contains($categorie2->id));

        $alert  = \App::make('App\Praticien\Bger\Worker\AlertInterface');
        $alert->setCadence('daily')->setDate($publication_at);

        $users = $alert->getUsers();

        $this->assertEquals(1,$users->count());
        $this->assertEquals($user->name,$users->first()['user']->name);
        $this->assertEquals(3,$users->first()['abos']->count());

        $alert->setCadence('weekly')->setDate($publication_at);
        $users = $alert->getUsers();

        $this->assertEquals(0,$users->count());
    }
}
