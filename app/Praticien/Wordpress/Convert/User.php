<?php namespace App\Praticien\Wordpress\Convert;

class User
{
    static function convert($data)
    {
        $metas = self::getMetas($data->meta);

        return array_filter([
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
        ]);
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
        return $abos->map(function ($abo, $key) {
            return $abo->refCategorie;
        })->unique()->map(function ($categorie, $key) use ($user) {
            $words = $user->abos->where('refCategorie', $categorie);

            return array_filter([
                'categorie_id' => $categorie,
                'keywords'     => array_filter($words->pluck('keywords')->unique()->toArray()),
                'isPub'        => !$user->published->where('refCategorie', $categorie)->pluck('ispub')->unique()->isEmpty()
            ]);
        })->toArray();
    }
}
