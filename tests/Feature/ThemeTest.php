<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeTest extends TestCase
{
    use RefreshDatabase;

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
