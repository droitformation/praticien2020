<?php namespace App\Praticien\Arret\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zoha\Metable;

class Arret extends Model {

    use Metable,SoftDeletes;

    protected $fillable = ['id','published_at','title','content','status','slug','guid','lang'];
    protected $dates    = ['published_at'];

    public function getTitleLinkAttribute()
    {
        return $this->getMeta('atf') ?? null;
    }

    public function categories()
    {
        return $this->belongsToMany('\App\Praticien\Categorie\Entities\Categorie', 'arret_categories', 'arret_id', 'categorie_id');
    }

    public function subcategories()
    {
        return $this->belongsToMany('\App\Praticien\Categorie\Entities\Categorie', 'arret_categories', 'arret_id', 'categorie_id')
            ->where('categories.parent_id','!=',0);
    }
}
