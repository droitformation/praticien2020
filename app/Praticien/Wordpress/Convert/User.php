<?php namespace App\Praticien\Wordpress\Convert;

use phpDocumentor\Reflection\Types\Self_;

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
            'cadence'      => isset($metas['rythme_abo']) ? getCadence($metas['rythme_abo']) : null,
            'active_until' => $metas['date_abo_active'] ?? $metas['valid_date'] ?? null,
            'abos'         => Self::getAbos($data->abos,$data),
            'role'         => isset($metas['wp_capabilities']) ? Self::getRoles($metas) : null,
        ]);
    }

    static function getRoles($metas){
        $wp_capabilities = unserialize($metas['wp_capabilities']);
        return getRole(array_keys($wp_capabilities));
    }

    static function getMetas($metas){
        return $metas->filter(function ($meta, $key) {
            return in_array($meta->meta_key,['first_name','last_name','rythme_abo','adresse','npa','wp_capabilities',
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
                'toPublish'    => !$user->published->where('refCategorie', $categorie)->pluck('ispub')->unique()->isEmpty()
            ]);
        })->toArray();
    }
}
