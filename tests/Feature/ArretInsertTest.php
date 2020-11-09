<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArretInsertTest extends TestCase
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
    public function testConvertAndInsertPost()
    {
        $post = $this->makeDataWordpressPost();

        $expected = [
            'id'           => 123,
            'published_at' => \Carbon\Carbon::yesterday()->toDateString(),
            'title'        => 'Un arrêt en suisse (f)',
            'content'      => '<p>The content</p>',
            'status'       => 'publish',
            'slug'         => 'un-arret-en-suisse-(f)',
            'guid'         => 'http://droitpourlepraticien.ch?page=123',
            'lang'         => 'f',
            'metas'        => collect([
                ['meta_key' => 'atf', 'meta_value' => 'Lien vers atf'],
                ['meta_key' => 'auteur', 'meta_value' => 'Cindy Leschaud'],
                ['meta_key' => 'termes_rechercher', 'meta_value' => '16:Cst.:3,20:LIPAD/GE'],
            ]),
            'themes'   => collect([25]),
            'year'     => collect(['2012-2013']),
        ];

        $converted = \App\Praticien\Wordpress\Convert\Arret::convert($post);

        $this->assertEquals($expected,$converted);
    }

    public function testInsertArretInDb()
    {
        $post  = $this->makeDataWordpressPost();
        $arret = \App\Praticien\Wordpress\Convert\Arret::convert($post);

        $repo = \App::make('App\Praticien\Arret\Repo\ArretInterface');
        $repo->insert($arret);

        $this->assertDatabaseHas('arrets', [
            'id'           => 123,
            'published_at' => \Carbon\Carbon::yesterday()->toDateTimeString(),
            'title'        => 'Un arrêt en suisse (f)',
            'content'      => '<p>The content</p>',
            'status'       => 'publish',
            'slug'         => 'un-arret-en-suisse-(f)',
            'guid'         => 'http://droitpourlepraticien.ch?page=123',
            'lang'         => 'f',
        ]);

        $this->assertDatabaseHas('meta', ['key' => 'atf', 'value' => 'Lien vers atf','owner_id' => 123]);
        $this->assertDatabaseHas('meta', ['key' => 'auteur', 'value' => 'Cindy Leschaud','owner_id' => 123]);
        $this->assertDatabaseHas('meta', ['key' => 'termes_rechercher', 'value' => '16:Cst.:3,20:LIPAD/GE','owner_id' => 123]);
        $this->assertDatabaseHas('meta', ['key' => 'year', 'value' => '2012-2013','owner_id' => 123]);

        $this->assertDatabaseHas('arret_themes', ['theme_id' => 25,'arret_id' => 123]);
    }

    public function makeDataWordpressPost()
    {
        $post = new \stdClass();
        $post->ID           = 123;
        $post->post_date    = \Carbon\Carbon::yesterday()->toDateString();
        $post->post_title   = 'Un arrêt en suisse (f)';
        $post->post_content = '<p>The content</p>';
        $post->post_status  = 'publish';
        $post->post_name    = 'un-arret-en-suisse-(f)';
        $post->guid         = 'http://droitpourlepraticien.ch?page=123';

        $metas1 = new \stdClass();
        $metas1->meta_key   = 'atf';
        $metas1->meta_value = 'Lien vers atf';

        $metas2 = new \stdClass();
        $metas2->meta_key   = 'auteur';
        $metas2->meta_value = 'Cindy Leschaud';

        $metas3 = new \stdClass();
        $metas3->meta_key   = 'termes_rechercher';
        $metas3->meta_value = '16:Cst.:3,20:LIPAD/GE';

        $post->meta = collect([$metas1,$metas2,$metas3]);

        $taxonomy = new \stdClass();
        $taxonomy->taxonomy = 'category';
        $taxonomy->term_id = 25;
        $taxonomy->parent = 0;

        $term = new \stdClass();
        $term->term_id = 25;
        $term->name    = 'Procédure administrative';
        $term->slug    = 'procedure-administrative';

        $taxonomy->term = $term;

        $taxonomy2 = new \stdClass();
        $taxonomy2->taxonomy = 'annee';
        $taxonomy2->term_id = 1;
        $taxonomy2->parent = 0;

        $term2= new \stdClass();
        $term2->term_id = 1;
        $term2->name    = '2012/2013';
        $term2->slug    = '2012-2013';

        $taxonomy2->term = $term2;

        $post->taxonomies  = collect([$taxonomy,$taxonomy2]);

        return $post;
    }
}
