<?php namespace App\Praticien\Wordpress\Convert;

class Arret
{
    static function convert($data)
    {
        return [
            'id'           => $data->ID,
            'published_at' => $data->post_date,
            'title'        => $data->post_title,
            'content'      => $data->post_content,
            'status'       => $data->post_status,
            'slug'         => $data->post_name,
            'guid'         => $data->guid,
            'lang'         => self::getLang($data->post_title),
            'metas'        => self::getMetas($data->meta),
            'themes'   => $data->taxonomies->where('taxonomy','category')->map(function ($theme) {
                return $theme->term->term_id;
            }),
            'year'   => $data->taxonomies->where('taxonomy','annee')->map(function ($theme) {
                return str_replace('/','-',$theme->term->name);
            })->values(),
        ];
    }

    static function getMetas($metas){
        return $metas->filter(function ($meta, $key) {
            return in_array($meta->meta_key,['termes_rechercher','auteur','atf','commentaire_pour_arrêt']);
        })->map(function ($meta, $key) {
            return [
                'meta_key'   => $meta->meta_key == 'commentaire_pour_arrêt' ? 'comment' : $meta->meta_key,
                'meta_value' => $meta->meta_value,
            ];
        });
    }

    static function getLang($title){
        $regex = '/\(([(f|d|i))]*)\)/';

        preg_match($regex,$title,$matches);

        return $matches[1] ?? null;
    }
}
