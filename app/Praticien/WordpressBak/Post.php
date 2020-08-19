<?php namespace App\Praticien\Wordpress;

use Illuminate\Support\Facades\DB;

class Post
{
    public function getPosts()
    {
        return DB::connection('wordpress')
            ->table('wp_posts')
            ->join('wp_postmeta', 'wp_posts.ID', '=', 'wp_postmeta.post_id', 'left')
            ->join('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id', 'left')
            ->join('wp_term_taxonomy', 'wp_term_relationships.term_taxonomy_id', '=', 'wp_term_taxonomy.term_taxonomy_id', 'left')
            ->where('wp_posts.post_status','=','publish')
            ->where('wp_posts.post_type','=','post')
            ->groupBy('wp_posts.ID')
            ->take(4)
            ->get();
    }
}

/*SELECT *
FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE wp_term_taxonomy.term_id IN (307)
GROUP BY wp_posts.ID*/
