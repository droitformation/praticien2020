<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Mail;

class CommandTest extends TestCase
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

    public function testSendAlertesCommand()
    {
        Queue::fake();

        $publication_at = \Carbon\Carbon::today()->startOfDay()->toDateTimeString();

        list($user,$decisions) = $this->makeDecisionAndAbos($publication_at);

        $this->artisan('send:alert',['cadence' => 'daily','date' => $publication_at]);

        Queue::assertPushed(function (\App\Jobs\SendEmailAlert $job) use ($publication_at) {
            return $job->publication_at === $publication_at && $job->cadence === 'daily';
        });
    }

    public function testSendAlertes()
    {
        Mail::fake();

        $publication_at = \Carbon\Carbon::today()->startOfDay()->toDateTimeString();

        list($user,$decisions) = $this->makeDecisionAndAbos($publication_at);

        $job = new \App\Jobs\SendEmailAlert($publication_at,'daily');
        $job->handle();

        Mail::assertQueued(function (\App\Mail\AlerteDecision $mail) use ($user) {
            return $mail->user->email === $user->email && $mail->decisions->count() === 3;
        });
    }

    public function testSendNoAlertes()
    {
        Mail::fake();

        $publication_at = \Carbon\Carbon::today()->startOfDay()->toDateTimeString();

        list($user,$decisions) = $this->makeDecisionAndAbos($publication_at);

        $job = new \App\Jobs\SendEmailAlert($publication_at,'weekly');
        $job->handle();

        Mail::assertNotSent(\App\Mail\AlerteDecision::class);
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

        $user = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(), 'cadence' => 'daily',
        ]);

        $abo1 = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id' => $user->id, 'categorie_id' => 174]);
        $abo2 = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id' => $user->id, 'categorie_id' => 175]);
        $abo3 = factory(\App\Praticien\Abo\Entities\Abo::class)->create(['user_id' => $user->id, 'categorie_id' => 176]);

        $keyword = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo1->id, 'keywords' => '"Accumasa laoreelentesque"']);
        $keyword = factory(\App\Praticien\Abo\Entities\Abo_keyword::class)->create(['abo_id' => $abo2->id, 'keywords' => '"à nul A égét 44",BGFA']);

        return [$user,$decisions];
    }
}
