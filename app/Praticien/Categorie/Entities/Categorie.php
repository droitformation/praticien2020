<?php namespace App\Praticien\Categorie\Entities;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model {

    protected $table    = 'categories';
	protected $fillable = ['name','name_de','name_it','parent_id','rang','general'];

    public $timestamps  = false;

    public function parent()
    {
        return $this->belongsTo('App\Praticien\Categorie\Entities\Parent_categorie');
    }
}
