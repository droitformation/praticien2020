<?php namespace App\Praticien\Arret\Entities;

class Prepare
{
    static function prepare($data)
    {
        return array_filter([
            'id'           => $data['id'] ?? null,
            'metas'        => $data['metas'],
            'themes'       => isset($data['subthemes']) && !empty($data['subthemes']) ? self::themes($data['subthemes'], $data['theme_id']) : null,
            'title'        => $data['title'],
            'slug'         => str_slug($data['title']),
            'content'      => $data['content'],
            'published_at' => $data['published_at'],
            'status'       => $data['status'],
            'lang'         => $data['lang'] ?? null,
        ]);
    }

    static function themes($array, $parent_id){

        $repo =\App::make('App\Praticien\Theme\Repo\ThemeInterface');

        foreach ($array as $index => $theme){
            if(strpos( $theme, 'new:' ) !== false){
                $term = str_replace('new:','',$theme);
                $new  = $repo->create(['name' => $term, 'slug' => str_slug($term),'parent_id' => $parent_id]);
                $array[$index] = $new->id;
            }
        }

        $array[] = $parent_id;

        return $array;
    }
}
