<?php namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeAboTest extends TestCase
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

    public function testSubscribeToCategorie()
    {
        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(),
            'cadence'      => 'daily',
        ]);

        $user->roles()->attach(2);
        $this->actingAs($user);

        $categorie1 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();
        $categorie2 = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();

        /*  user_id: this.user_id, categorie_id: this.categorie_id, keywords: this.words, toPublish: this.aPublier */

        $data1 = ['user_id' => $user->id, 'categorie_id' => $categorie1->id];

        $this->assertDatabaseMissing('abos', $data1);
        $response = $this->call('POST', 'abo/subscribe', $data1);
        $this->assertDatabaseHas('abos', $data1);

        $data2 = ['user_id' => $user->id, 'categorie_id' => $categorie2->id, 'toPublish' => 1];

        $this->assertDatabaseMissing('abos', $data2);
        $response = $this->call('POST', 'abo/subscribe', $data2);
        $this->assertDatabaseHas('abos', $data2);

        $data3 = ['user_id' => $user->id, 'categorie_id' => $categorie1->id, 'toPublish' => 1];

        $this->assertDatabaseMissing('abos', $data3);
        $response = $this->call('POST', 'abo/subscribe', $data3 + ['keywords' => ['BGFA,CPCP']]);

        $this->assertDatabaseHas('abos', $data3);
        $this->assertDatabaseHas('abo_keywords', ['keywords' => 'BGFA,CPCP']);

        $expect = collect([
            $categorie1->id => ['title' => $categorie1->name, 'keywords' => collect([collect(['BGFA','CPCP'])]), 'published' => 1],
            $categorie2->id => ['title' => $categorie2->name, 'keywords' => collect([collect([])]), 'published' => 1],
        ]);

        $this->assertEquals($expect->toArray(),$user->abonnements->toArray());
    }
}
