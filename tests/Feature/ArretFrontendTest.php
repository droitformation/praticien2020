<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArretFrontendTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');

        $user = factory(\App\Praticien\User\Entities\User::class)->create();
        $user->roles()->attach(2);
        $this->actingAs($user);
    }

    public function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testCreateArretForFuture()
    {
        $theme1 = factory(\App\Praticien\Theme\Entities\Theme::class)->create(['name' => 'TEST']);
        $theme2 = factory(\App\Praticien\Theme\Entities\Theme::class)->create(['parent_id' => $theme1->id]);

        $published_at = \Carbon\Carbon::today()->addDays(5)->toDateTimeString();

        $data = [
            'metas' => [
                'year' => '2019-2020',
                'atf'  => 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F146-II-36%3Afr&lang=fr&zoom=&type=show_document',
                'termes_rechercher' => '8:LPE,10a:LPE,37LA,37m:LA',
                'auteur' => 'Cindy Leschaud',
            ],
            'theme_id'  => $theme1->id,
            'status'    => 'futur',
            'subthemes' => [$theme2->id],
            'title'        => 'ATF 146 II 36',
            'content'      => 'art. 8 et 10a LPE, art. 37 et 37m LA; Fames integer pésuéré egéstat vestibulum.',
            'published_at' => $published_at
        ];

        $response = $this->call('POST', 'backend/arret', $data);
        $page     = $this->call('GET', 'theme/'.$theme1->slug, $data);

        // Arret is in the future
        $page->assertDontSee('ATF 146 II 36');

    }

    public function testCreateArretForNow()
    {
        $theme1 = factory(\App\Praticien\Theme\Entities\Theme::class)->create(['name' => 'TEST']);
        $theme2 = factory(\App\Praticien\Theme\Entities\Theme::class)->create(['parent_id' => $theme1->id]);

        $published_at = \Carbon\Carbon::today()->toDateTimeString();

        $data = [
            'metas' => [
                'year' => '2019-2020',
                'atf'  => 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F146-II-36%3Afr&lang=fr&zoom=&type=show_document',
                'termes_rechercher' => '8:LPE,10a:LPE,37LA,37m:LA',
                'auteur' => 'Cindy Leschaud',
            ],
            'theme_id'  => $theme1->id,
            'status'    => 'futur',
            'subthemes' => [$theme2->id],
            'title'        => 'ATF 146 II 36',
            'content'      => 'art. 8 et 10a LPE, art. 37 et 37m LA; Fames integer pésuéré egéstat vestibulum.',
            'published_at' => $published_at
        ];

        $response = $this->call('POST', 'backend/arret', $data);
        $page     = $this->call('GET', 'theme/'.$theme1->slug, $data);

        $page->assertSee('ATF 146 II 36');
        $page->assertSee($theme1->name);
        $page->assertSee($theme2->name);
    }
}
