<?php namespace App\Praticien\Categorie\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorie extends Model {

    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = ['id','name','slug','parent_id'];
    protected $dates    = ['deleted_at'];

    public function subcategory(){
        return $this->hasMany('\App\Praticien\Categorie\Entities\Categorie', 'parent_id');
    }

    public function arrets()
    {
        return $this->belongsToMany('\App\Praticien\Arret\Entities\Arret', 'arret_categories', 'categorie_id', 'arret_id');
    }

    public function parent(){
        return $this->hasOne('\App\Praticien\Categorie\Entities\Categorie', 'id','parent_id');
    }
}
