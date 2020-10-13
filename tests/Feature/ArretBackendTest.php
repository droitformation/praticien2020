<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Praticien\User\Entities\User as User;
use App\Praticien\Theme\Entities\Theme as Theme;
use App\Praticien\Arret\Entities\Arret as Arret;

class ArretBackendTest extends TestCase
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

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPrepareArret()
    {
        $data = [
            'metas' => [
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

    public function testPrepareArretOneTheme()
    {
        $data = [
            'metas' => [
                'year' => '2019-2020',
                'atf'  => 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F146-II-36%3Afr&lang=fr&zoom=&type=show_document',
                'termes_rechercher' => '8:LPE,10a:LPE,37LA,37m:LA'
            ],
            'theme_id'     => 5,
            'status'       => 'futur',
            'title'        => 'ATF 146 II 36',
            'content'      => 'art. 8 et 10a LPE, art. 37 et 37m LA; Fames integer pésuéré egéstat vestibulum.',
            'published_at' => '2020-09-30',
        ];

        $prepared = \App\Praticien\Arret\Entities\Prepare::prepare($data);

        $this->assertTrue(isset($prepared['themes']));
        $this->assertTrue(in_array(5,$prepared['themes']));
        $this->assertEquals(1,count($prepared['themes']));
    }

    public function testCreateArret()
    {
        $data = [
            'metas' => [
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
            'status'       => 'publish',
            'title'        => 'ATF 146 II 36',
            'content'      => 'art. 8 et 10a LPE, art. 37 et 37m LA; Fames integer pésuéré egéstat vestibulum.',
            'published_at' => '2020-09-30',
        ]);

        $this->assertDatabaseHas('meta', ['key' => 'atf', 'value' => 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F146-II-36%3Afr&lang=fr&zoom=&type=show_document']);
        $this->assertDatabaseHas('meta', ['key' => 'auteur', 'value' => 'Cindy Leschaud']);
        $this->assertDatabaseHas('meta', ['key' => 'termes_rechercher', 'value' => '8:LPE,10a:LPE,37LA,37m:LA']);
        $this->assertDatabaseHas('meta', ['key' => 'year', 'value' => '2019-2020']);
    }

    public function testUpdateArret()
    {
        $theme1 = Theme::factory()->create();
        $theme2 = Theme::factory()->create(['parent_id' => $theme1->id]);

        $theme3 = Theme::factory()->create();
        $theme4 = Theme::factory()->create(['parent_id' => $theme3->id]);

        $arret = Arret::factory()->create([
            'title'        => 'ATF 146 II 36',
            'status'       => 'publish',
            'content'      => 'art. 8 et 10a LPE, art. 37 et 37m LA; Fames integer pésuéré egéstat vestibulum.',
            'published_at' => '2020-09-30',
        ]);

        $arret->themes()->attach([$theme1->id,$theme2->id]);

        $arret->setMeta([
            'year' => '2019-2020',
            'atf'  => 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F146-II-36%3Afr&lang=fr&zoom=&type=show_document',
            'termes_rechercher' => '8:LPE,10a:LPE,37LA,37m:LA',
            'auteur' => 'Cindy Leschaud',
        ]);

        $data = [
            'id'           => $arret->id,
            'title'        => 'ATF 146 I 37',
            'status'       => 'futur',
            'content'      => 'art. 6 et 38m LA; Fames pésuéré egéstat vestibulum.',
            'published_at' => '2020-10-01',
            'metas'    => [
                'year' => '2018-2019',
                'atf'  => 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F146-III-36%3Afr&lang=fr&zoom=&type=show_document',
                'termes_rechercher' => '10a:LPE,37LA,8:LPE,37m:LA',
                'auteur' => 'Coralie Ahmetaj',
            ],
            'theme_id'   => $theme1->id,
            'subthemes'  => [$theme3->id,$theme4->id],
        ];

        $response = $this->call('PUT', 'backend/arret/'.$arret->id, $data);

        $this->assertDatabaseHas('arrets', [
            'id'           => $arret->id,
            'title'        => 'ATF 146 I 37',
            'status'       => 'publish',
            'content'      => 'art. 6 et 38m LA; Fames pésuéré egéstat vestibulum.',
            'published_at' => '2020-10-01',
        ]);

        $this->assertDatabaseHas('meta', ['key' => 'atf', 'value' => 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F146-III-36%3Afr&lang=fr&zoom=&type=show_document']);
        $this->assertDatabaseHas('meta', ['key' => 'auteur', 'value' => 'Coralie Ahmetaj']);
        $this->assertDatabaseHas('meta', ['key' => 'termes_rechercher', 'value' => '10a:LPE,37LA,8:LPE,37m:LA']);
        $this->assertDatabaseHas('meta', ['key' => 'year', 'value' => '2018-2019']);
    }

    public function testSearchArret()
    {
        $theme1 = Theme::factory()->create();
        $arret  = Arret::factory()->create([
            'title'        => 'ATF 146 II 36',
            'status'       => 'publish',
            'content'      => 'art. 8 et 10a LPE, art. 37 et 37m LA; Fames integer pésuéré egéstat vestibulum.',
            'published_at' => '2020-09-30',
        ]);

        $arret->themes()->attach([$theme1->id]);
        $arret->setMeta(['year' => '2019-2020','termes_rechercher' => '8:LPE,10a:LPE,37LA,37m:LA']);

        $repo = \App::make('App\Praticien\Arret\Repo\ArretInterface');

        $params = [
            'article' => '8',
            'loi'     => 'LPE',
        ];

        $result = $repo->searchLoi($params);

        $this->assertEquals(1,$result->count());

        $params = [
            'article' => '37m',
            'loi'     => 'LA',
        ];

        $result = $repo->searchLoi($params);

        $this->assertEquals(1,$result->count());
    }
}
