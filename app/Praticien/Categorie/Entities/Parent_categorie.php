<?php namespace App\Praticien\Categorie\Entities;

use Illuminate\Database\Eloquent\Model;

class Parent_categorie extends Model {

	protected $fillable = ['id','nom','rang'];

    public $timestamps  = false;

    public function categories()
    {
        return $this->hasMany('App\Praticien\Categorie\Entities\Categorie', 'parent_id', 'id');
    }
}
