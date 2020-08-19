<?php namespace App\Praticien\Wordpress\Convert;

class Categorie
{
    static function convert($data)
    {
        return [
            'id'        => $data->term->term_id,
            'name'      => $data->term->name,
            'slug'      => $data->term->slug,
            'parent_id' => $data->parent,
        ];
    }
}
