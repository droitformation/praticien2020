<?php namespace App\Praticien\Categorie\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model {

    use HasFactory;

    protected $table    = 'categories';
	protected $fillable = ['name','name_de','name_it','parent_id','rang','general'];

    public $timestamps  = false;

    protected static function newFactory()
    {
        return \Database\Factories\CategorieFactory::new();
    }

    public function parent()
    {
        return $this->belongsTo('App\Praticien\Categorie\Entities\Parent_categorie');
    }
}
