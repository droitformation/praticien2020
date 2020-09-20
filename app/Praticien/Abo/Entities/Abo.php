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

    public function categorie()
    {
        return $this->belongsTo('\App\Praticien\Categorie\Entities\Categorie');
    }

    public function decisions()
    {
       // return $this->hasManyThrough('App\Praticien\Categorie\Entities\Categorie','App\Praticien\Decision\Entities\Decision','categorie_id','id','categorie_id','categorie_id');
        return $this->hasManyThrough('App\Praticien\Decision\Entities\Decision','App\Praticien\Categorie\Entities\Categorie','id','categorie_id','categorie_id','id');

    }
}
