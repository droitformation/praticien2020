<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorieTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testConvertCategorie()
    {
        $taxonomy = $this->makeDataWordpressCategorie();

        $expected = [
            'id'        => 123,
            'name'      => 'Général',
            'slug'      => 'general',
            'parent_id' => 0,
        ];

        $converted = \App\Praticien\Wordpress\Convert\Categorie::convert($taxonomy);

        $this->assertEquals($expected,$converted);
    }

    public function testInsertCategorie()
    {
        $taxonomy = $this->makeDataWordpressCategorie();

        $converted = \App\Praticien\Wordpress\Convert\Categorie::convert($taxonomy);

        $repo = \App::make('App\Praticien\Categorie\Repo\CategorieInterface');
        $repo->create($converted);

        $this->assertDatabaseHas('categories', [
            'id'        => 123,
            'name'      => 'Général',
            'slug'      => 'general',
            'parent_id' => 0,
        ]);
    }

    public function makeDataWordpressCategorie(){
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
