<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Mail;
use App\Praticien\Code\Entities\Code as Code;
use App\Praticien\User\Entities\User as User;

class CodeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');

        $user = User::factory()->create();
        $user->roles()->attach(1);
        $this->actingAs($user);
    }

    public function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testMakeBigNbrCodes()
    {
        $response = $this->post('backend/code', ['nbr' => 800, 'valid_at' => \Carbon\Carbon::today()->addYear()]);

        $repo = \App::make('App\Praticien\Code\Repo\CodeInterface');

        $all = $repo->getAll(\Carbon\Carbon::today()->addYear()->year);

        $this->assertEquals(800,$all->count());
    }
}
