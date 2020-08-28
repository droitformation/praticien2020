<?php namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserWorkerTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteAbo()
    {
        $worker = \App::make('App\Praticien\User\Worker\SubscriptionWorker');

        $user      = factory(\App\Praticien\User\Entities\User::class)->create();
        $categorie = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();

        $abo     = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id' => $user->id, 'categorie_id' => $categorie->id]);
        $keyword = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo->id, 'keywords' => 'Lorem, ipsum dolor']);

        $this->assertTrue($user->abos->contains('categorie_id',$categorie->id));

        $worker->delete($user->id, $categorie->id);

        $user = $user->fresh();

        $this->assertFalse($user->abos->contains('categorie_id',$categorie->id));

    }

    public function testCreateAbo()
    {
        $worker = \App::make('App\Praticien\User\Worker\SubscriptionWorker');

        $user      = factory(\App\Praticien\User\Entities\User::class)->create();
        $categorie = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();

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

        $user      = factory(\App\Praticien\User\Entities\User::class)->create();
        $categorie = factory(\App\Praticien\Categorie\Entities\Categorie::class)->create();

        $abo     = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id' => $user->id, 'categorie_id' => $categorie->id]);
        $keyword = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo->id, 'keywords' => 'Lorem, ipsum dolor']);

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
