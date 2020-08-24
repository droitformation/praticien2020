<?php namespace App\Praticien\Wordpress\Convert;

class User
{
    static function convert($data)
    {
        $metas = self::getMetas($data->meta);

        return [
            'id'           => $data->ID,
            'first_name'   => $metas['first_name'] ?? $data->user_nicename,
            'last_name'    => $metas['last_name'] ?? '',
            'email'        => $data->user_email,
            'password'     => $data->user_pass,
            'adresse'      => $metas['adresse'] ?? $metas['adresse_professionnelle'] ?? '',
            'npa'          => $metas['npa'] ?? $metas['npa_prof'] ?? '',
            'ville'        => $metas['ville'] ?? $metas['ville_prof'] ?? '',
            'cadence'      => $metas['rythme_abo'] ?? null,
            'active_until' => $metas['date_abo_active'] ?? $metas['valid_date'] ?? null,
            'abos'         => Self::getAbos($data->abos,$data)
        ];
    }

    static function getMetas($metas){
        return $metas->filter(function ($meta, $key) {
            return in_array($meta->meta_key,['first_name','last_name','rythme_abo','adresse','npa',
                'ville','profession','adresse_professionnelle','npa_prof','ville_prof','tel_prof','date_abo_active','valid_date','user_meta_user_status']);
        })->mapWithKeys(function ($meta, $key) {
            return [$meta->meta_key => $meta->meta_value];
        })->toArray();
    }

    static function getAbos($abos,$user){
        return $abos->mapToGroups(function ($abo, $key) use ($user) {
            return [
                $abo->refCategorie => array_filter([
                    'keywords' => $abo->keywords,
                    'isPub'    => $user->published->contains('refCategorie', $abo->refCategorie)
                ])
            ];
        })->map(function ($keywords, $categorie_id) {
            return $keywords->reject(function ($keyword) {
                return empty(array_filter($keyword));
            })->toArray();
        })->toArray();
    }
}
