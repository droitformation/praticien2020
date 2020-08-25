<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AboTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testMakeAbo()
    {
        $worker = \App::make('App\Praticien\Abo\Worker\AboWorkerInterface');

        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(),
            'cadence'      => 'daily',
        ]);

        $data = [
            'user_id'      => $user->id,
            'categorie_id' => 199,
            'keywords'     => ['Lorem ipsum dolor','Ispum dolor amet']
        ];

        $worker->make($data);

        $this->assertDatabaseHas('abos', [
            'user_id'      => $user->id,
            'categorie_id' => 199,
            'keywords'     => 'Lorem ipsum dolor'
        ]);

        $this->assertDatabaseHas('abos', [
            'user_id'      => $user->id,
            'categorie_id' => 199,
            'keywords'     => 'Ispum dolor amet'
        ]);
    }

    public function testRemoveAbo()
    {
        $worker = \App::make('App\Praticien\Abo\Worker\AboWorkerInterface');

        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(),
            'cadence'      => 'daily',
        ]);

        $data = [
            'user_id'      => $user->id,
            'categorie_id' => 199,
            'keywords'     => ['Lorem ipsum dolor']
        ];

        $worker->make($data);

        $data = ['user_id' => $user->id, 'categorie_id' => 199];

        $worker->remove($data);

        $this->assertDatabaseMissing('abos', [
            'user_id'      => $user->id,
            'categorie_id' => 199,
            'keywords'     => 'Lorem ipsum dolor'
        ]);
    }

    public function testKeywordList()
    {
        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(),
            'cadence'      => 'daily',
        ]);

        $categorie = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();

        $abo = factory(\App\Praticien\Abo\Entities\Abo::class)->create([
            'user_id'      => $user->id,
            'categorie_id' => $categorie->id,
            'keywords'     => 'Lorem, ipsum dolor'
        ]);

        $this->assertEquals(collect(['Lorem','ipsum dolor']),$abo->keywords_list);

        $abo1 = factory(\App\Praticien\Abo\Entities\Abo::class)->create([
            'user_id'      => $user->id,
            'categorie_id' => $categorie->id,
            'keywords'     => 'Lorem; ipsum dolor'
        ]);

        $this->assertEquals(collect(['Lorem','ipsum dolor']),$abo1->keywords_list);
    }
}
