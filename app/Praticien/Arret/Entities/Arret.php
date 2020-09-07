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

    public function getMainThemeAttribute()
    {
        return $this->themes->first();
    }

    public function getMainThemeSelectAttribute()
    {
        return ['id' => $this->themes->first()->id, 'text' => $this->themes->first()->name];
    }

    public function getSubthemesListAttribute()
    {
        return $this->subthemes->map(function ($theme) {
            return ['id' => $theme->id, 'text' => $theme->name];
        });
    }

    public function scopeEdition($query, $edition)
    {
        if(isset($edition)){
            $query->whereMeta('year', $edition);
        }
    }

    public function themes()
    {
        return $this->belongsToMany('\App\Praticien\Theme\Entities\Theme', 'arret_themes', 'arret_id', 'theme_id');
    }

    public function subthemes()
    {
        return $this->belongsToMany('\App\Praticien\Theme\Entities\Theme', 'arret_themes', 'arret_id', 'theme_id')
            ->where('themes.parent_id','!=',0);
    }
}
