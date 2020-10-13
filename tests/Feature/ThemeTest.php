<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Praticien\Theme\Entities\Theme as Theme;
use App\Praticien\Arret\Entities\Arret as Arret;

class ThemeTest extends TestCase
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
    public function testConvertTheme()
    {
        $taxonomy = $this->makeDataWordpressTheme();

        $expected = [
            'id'        => 123,
            'name'      => 'Général',
            'slug'      => 'general',
            'parent_id' => 0,
        ];

        $converted = \App\Praticien\Wordpress\Convert\Theme::convert($taxonomy);

        $this->assertEquals($expected,$converted);
    }

    public function testInsertTheme()
    {
        $taxonomy = $this->makeDataWordpressTheme();

        $converted = \App\Praticien\Wordpress\Convert\Theme::convert($taxonomy);

        $repo = \App::make('App\Praticien\Theme\Repo\ThemeInterface');
        $repo->create($converted);

        $this->assertDatabaseHas('themes', [
            'id'        => 123,
            'name'      => 'Général',
            'slug'      => 'general',
            'parent_id' => 0,
        ]);
    }

    public function testThemeCanBeDeleted()
    {
        $theme1 = Theme::factory()->create();
        $theme2 = Theme::factory()->create(['parent_id' => $theme1->id]);
        $arret  = Arret::factory()->create();

        $arret->themes()->attach([$theme1->id,$theme2->id]);
        $arret = $arret->fresh();

        $this->assertTrue($theme2->can_be_deleted);
        $this->assertFalse($theme1->can_be_deleted);
    }

    public function testThemeCanBeDeleted2()
    {
        $theme1 = Theme::factory()->create();
        $theme2 = Theme::factory()->create(['parent_id' => $theme1->id]);

        $this->assertTrue($theme2->can_be_deleted);
        $this->assertTrue($theme1->can_be_deleted);
    }

    public function makeDataWordpressTheme(){
        $taxonomy = new \stdClass();
        $taxonomy->term_id = 123;
        $taxonomy->parent = 0;

        $term = new \stdClass();
        $term->term_id = 123;
        $term->name = 'Général';
        $term->slug = 'general';

        $taxonomy->term = $term;

        return $taxonomy;
    }
}
