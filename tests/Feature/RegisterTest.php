<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
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

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegisterWithCodeAndSuccess()
    {
        $response = $this->get('/access');

        $code = factory(\App\Praticien\Code\Entities\Code::class)->create();

        $data = [
            'first_name'    => 'Marc',
            'last_name'     => 'Leschaud',
            'email'         => 'marc.leschaud@romandie.com',
            'adresse'       => 'La Voirde 19',
            'npa'           => '2735',
            'ville'         => 'Bévilard',
            'password'      => 'secret1234',
            'password_confirmation' => 'secret1234',
            'code'          => $code->code,
        ];

        $this->assertDatabaseMissing('users', array_except($data,['password','code','password_confirmation']));

        $response = $this->call('POST', 'register', $data);

        $response->assertRedirect('/home');

        $this->assertDatabaseHas('users', array_except($data,['password','code','password_confirmation']));

        $code = $code->fresh();

        $this->assertNotNull($code->user_id);

        $user = $code->user;

        $this->assertTrue($user->roles->contains('id',2));

    }
    public function testRegisterNotValidCode()
    {
        $code = factory(\App\Praticien\Code\Entities\Code::class)->create([
            'valid_at' => \Carbon\Carbon::yesterday()->toDateString(),
        ]);

        $data = [
            'first_name'    => 'Marc',
            'last_name'     => 'Leschaud',
            'email'         => 'marc.leschaud@romandie.com',
            'adresse'       => 'La Voirde 19',
            'npa'           => '2735',
            'ville'         => 'Bévilard',
            'password'      => 'secret1234',
            'password_confirmation' => 'secret1234',
            'code'          => $code->code,
        ];

        $this->assertDatabaseMissing('users', array_except($data,['password','code','password_confirmation']));

        $response = $this->call('POST', 'register', $data);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors('code');
    }
}
