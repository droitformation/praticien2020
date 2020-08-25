<?php namespace App\Praticien\Abo\Entities;

use Illuminate\Database\Eloquent\Model;

class Abo extends Model
{
    protected $table    = 'abos';
    public $timestamps  = false;
    protected $fillable = ['user_id', 'categorie_id','toPublish'];

    public function keywords()
    {
        return $this->hasMany('\App\Praticien\Abo\Entities\Abo_keyword');
    }
}
