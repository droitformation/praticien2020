<?php namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Praticien\Code\Entities\Code as Code;
use App\Praticien\User\Entities\User as User;
use App\Praticien\Abo\Entities\Abo as Abo;
use App\Praticien\Abo\Entities\Abo_keyword as Abo_keyword;
use App\Praticien\Categorie\Entities\Categorie as Categorie;

class UserWorkerTest extends TestCase
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

    public function testDeleteAbo()
    {
        $worker = \App::make('App\Praticien\User\Worker\SubscriptionWorker');

        $user      = User::factory()->create();
        $categorie = Categorie::factory()->create();

        $abo     = Abo::factory()->create(['user_id' => $user->id, 'categorie_id' => $categorie->id]);
        $keyword = Abo_keyword::factory()->create(['abo_id' => $abo->id, 'keywords' => 'Lorem, ipsum dolor']);

        $this->assertTrue($user->abos->contains('categorie_id',$categorie->id));

        $worker->delete($user->id, $categorie->id);

        $user = $user->fresh();

        $this->assertFalse($user->abos->contains('categorie_id',$categorie->id));

    }

    public function testCreateAbo()
    {
        $worker = \App::make('App\Praticien\User\Worker\SubscriptionWorker');

        $user      = User::factory()->create();
        $categorie = Categorie::factory()->create();

        $this->assertTrue($user->abos->isEmpty());

        $worker->update($user->id, ['categorie_id' => $categorie->id, 'keywords' => ['One','Two']]);

        $user = $user->fresh();
        $abo  = $user->abos->firstWhere('categorie_id',$categorie->id);

        $keywords = $abo->keywords->map(function ($keyword) {
            return $keyword->keywords;
        })->flatten()->toArray();

        $this->assertEquals(['One','Two'],$keywords);
    }

    public function testUpdateAbo()
    {
        $worker = \App::make('App\Praticien\User\Worker\SubscriptionWorker');

        $user      = User::factory()->create();
        $categorie = Categorie::factory()->create();

        $abo     = Abo::factory()->create(['user_id' => $user->id, 'categorie_id' => $categorie->id]);
        $keyword = Abo_keyword::factory()->create(['abo_id' => $abo->id, 'keywords' => 'Lorem, ipsum dolor']);

        $this->assertTrue($user->abos->contains('categorie_id',$categorie->id));

        $worker->update($user->id, ['categorie_id' => $categorie->id, 'keywords' => ['One','Two'],'toPublish' => false]);

        $user = $user->fresh();
        $abo  = $abo->fresh();

        $keywords = $abo->keywords->map(function ($keyword) {
            return $keyword->keywords;
        })->flatten()->toArray();

        $this->assertEquals(['One','Two'],$keywords);
    }
}
