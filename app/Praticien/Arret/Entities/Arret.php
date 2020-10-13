<?php namespace App\Praticien\Arret\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zoha\Metable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Arret extends Model {

    use Metable,SoftDeletes,HasFactory;

    protected $fillable = ['id','published_at','title','content','text_content','status','slug','guid','lang'];
    protected $dates    = ['published_at'];

    protected static function newFactory()
    {
        return \Database\Factories\ArretFactory::new();
    }

    public function getTitleLinkAttribute()
    {
        return extractUrl($this->getMeta('atf'),$this->title);
    }

    public function getMainThemeAttribute()
    {
        return $this->themes->where('parent_id',0)->first();
    }

    public function getMainThemeSelectAttribute()
    {
        $theme = $this->themes->where('parent_id',0)->first();

        if($theme){
            return ['id' => $theme->id, 'text' => $theme->name, 'subthemes' => $theme->subthemes->map(function ($subtheme) {
                return ['id' => $subtheme->id, 'text' => $subtheme->name];
            })->toArray()];
        }

        return [];
    }

    public function getSubthemesListAttribute()
    {
        return $this->subthemes->map(function ($theme) {
            return $theme->id;
        });
    }

    public function scopeEdition($query, $edition)
    {
        if(isset($edition)){
            $query->whereMeta('year', $edition);
        }
    }

    public function scopeSort($query, $col, $sort)
    {
        if(isset($col) && isset($sort)){

            if($col == 'title'){
                $query->orderBy($col,$sort);
            }

            if($col == 'theme'){
                $query->with('themes', function ($query) use ($sort) {
                    $query->orderBy('name',$sort);
                });
            }

        }
    }

    public function scopeSearch($query,$terms)
    {
        if($terms && !empty($terms)){
                $terms = prepareSearchTerms($terms);
            $query->whereRaw('MATCH (text_content) AGAINST (? IN BOOLEAN MODE)', array($terms));
        }
    }

    public function scopeLoi($query,$params)
    {
        if($params && !empty($params)) {
            $p = prepareParams($params);
            $query->whereMeta('termes_rechercher','LIKE' ,'%'.$p.'%')
                ->orWhereMeta('termes_rechercher','LIKE' ,':'.$p.'%')
                ->orWhereMeta('termes_rechercher', ':'.$p)
                ->orWhereMeta('termes_rechercher', $p)
            ->orWhere('content','LIKE','%'.prepareParamsContent($params).'%');
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
