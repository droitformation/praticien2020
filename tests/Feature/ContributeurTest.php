<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContributeurTest extends TestCase
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

    public function testHasAccessToBackend()
    {
        $contributeur = factory(\App\Praticien\User\Entities\User::class)->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(),
        ]);

        $contributeur->roles()->attach(2);
        $this->actingAs($contributeur);

        $response = $this->get('backend');
        $response->assertStatus(200);

        $response->assertSeeText('Arrêts résumés');
        $response->assertDontSee('Décision du TF');
        $response->assertDontSee('Alertes email');
    }

}
