<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArretBackendTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');

        $user = factory(\App\Praticien\User\Entities\User::class)->create();
        $user->roles()->attach(1);
        $this->actingAs($user);
    }

    public function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPrepareArret()
    {
        $data = [
            'meta' => [
                'year' => '2019-2020',
                'atf'  => 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F146-II-36%3Afr&lang=fr&zoom=&type=show_document',
                'termes_rechercher' => '8:LPE,10a:LPE,37LA,37m:LA'
            ],
            'theme_id'  => 5,
            'status'    => 'futur',
            'subthemes' => [
                343,358,'new:other'
            ],
            'title'        => 'ATF 146 II 36',
            'content'      => 'art. 8 et 10a LPE, art. 37 et 37m LA; Fames integer pésuéré egéstat vestibulum.',
            'published_at' => '2020-09-30',
        ];

        $prepared = \App\Praticien\Arret\Entities\Prepare::prepare($data);

        $this->assertTrue(isset($prepared['themes']));
        $this->assertTrue(in_array(5,$prepared['themes']));
        $this->assertEquals(4,count($prepared['themes']));

        $this->assertDatabaseHas('themes', ['name' => 'other', 'slug' => 'other', 'parent_id' => 5]);
    }

    public function testCreateArret()
    {
        $data = [
            'meta' => [
                'year' => '2019-2020',
                'atf'  => 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F146-II-36%3Afr&lang=fr&zoom=&type=show_document',
                'termes_rechercher' => '8:LPE,10a:LPE,37LA,37m:LA',
                'auteur' => 'Cindy Leschaud',
            ],
            'theme_id'  => 5,
            'status'    => 'futur',
            'subthemes' => [
                343,358,'new:other2'
            ],
            'title'        => 'ATF 146 II 36',
            'content'      => 'art. 8 et 10a LPE, art. 37 et 37m LA; Fames integer pésuéré egéstat vestibulum.',
            'published_at' => '2020-09-30',
        ];

        $response = $this->call('POST', 'backend/arret', $data);

        $this->assertDatabaseHas('themes', [
            'name'      => 'other2',
            'slug'      => 'other2',
            'parent_id' => 5,
        ]);

        $this->assertDatabaseHas('arrets', [
            'status'       => 'futur',
            'title'        => 'ATF 146 II 36',
            'content'      => 'art. 8 et 10a LPE, art. 37 et 37m LA; Fames integer pésuéré egéstat vestibulum.',
            'published_at' => '2020-09-30',
        ]);

        $this->assertDatabaseHas('meta', ['key' => 'atf', 'value' => 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F146-II-36%3Afr&lang=fr&zoom=&type=show_document']);
        $this->assertDatabaseHas('meta', ['key' => 'auteur', 'value' => 'Cindy Leschaud']);
        $this->assertDatabaseHas('meta', ['key' => 'termes_rechercher', 'value' => '8:LPE,10a:LPE,37LA,37m:LA']);
        $this->assertDatabaseHas('meta', ['key' => 'year', 'value' => '2019-2020']);
    }
}
