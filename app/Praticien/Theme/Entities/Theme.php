<?php namespace App\Praticien\Theme\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model {

    use SoftDeletes;

    protected $table = 'themes';

    protected $fillable = ['id','name','slug','parent_id'];
    protected $dates    = ['deleted_at'];

    public function getCanBeDeletedAttribute()
    {
        $count = $this->arrets_count ? $this->arrets_count : $this->arrets->count();

        return ($this->parent_id > 0 && $this->arrets_count >= 0) || ($this->parent_id == 0 && $count == 0);
    }

    public function subthemes(){
        return $this->hasMany('\App\Praticien\Theme\Entities\Theme', 'parent_id');
    }

    public function arrets()
    {
        return $this->belongsToMany('\App\Praticien\Arret\Entities\Arret', 'arret_themes', 'theme_id', 'arret_id');
    }

    public function parent(){
        return $this->hasOne('\App\Praticien\Theme\Entities\Theme', 'id','parent_id');
    }
}
