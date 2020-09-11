<?php namespace App\Praticien\Wordpress\Convert;

class Code
{
    static function convert($data)
    {
        return [
            'id'         => $data->id_code,
            'code'       => $data->number_code,
            'valid_at'   => $data->validity_code,
            'user_id'    => $data->user_id > 0 ? $data->user_id : null,
            'updated_at' => $data->updated,
        ];
    }
}
