<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Praticien\User\Entities\User as User;

class UserBackendTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');

        $user = User::factory()->create([
            'active_until' => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(),
        ]);

        $user->roles()->attach(1);
        $this->actingAs($user);

        $this->user = $user;
    }

    public function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testUpdateUserFromBackend()
    {
        $abonne = User::factory()->create([
            'first_name'    => 'Jane',
            'last_name'     => 'Doe',
            'email'         => 'cindy.leschaud@gmail.com',
            'adresse'       => 'Rue du Marché-Neuf 14',
            'npa'           => '2502' ,
            'ville'         => 'Bienne',
            'active_until'  => \Carbon\Carbon::today()->startOfDay()->addMonth()->toDateTimeString(),
        ]);

        $abonne->roles()->attach(2);

        $data = [
            'id'            => $abonne->id,
            'first_name'    => 'Jane',
            'last_name'     => 'Doe',
            'email'         => 'hello@domain.ch',
            'adresse'       => 'Rue du test 123',
            'npa'           => '1234' ,
            'ville'         => 'Manhattan',
            'active_until'  => '2020-12-31',
            'role'          => 3,
        ];

        $response = $this->call('PUT', 'backend/user/'.$abonne->id, $data);

        $abonne = $abonne->fresh();

        $this->assertTrue($abonne->roles->contains('id',3));
        $this->assertFalse($abonne->roles->contains('id',2));

        $this->assertDatabaseHas('users', [
            'id'            => $abonne->id,
            'first_name'    => 'Jane',
            'last_name'     => 'Doe',
            'email'         => 'hello@domain.ch',
            'adresse'       => 'Rue du test 123',
            'npa'           => '1234' ,
            'ville'         => 'Manhattan',
            'active_until'  => '2020-12-31',
        ]);
    }
}
