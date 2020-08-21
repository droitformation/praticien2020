<?php namespace App\Praticien\User\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;

    protected $dates = ['active_until'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password', 'adresse','npa','ville','cadence','active_until'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAbonnementsAttribute()
    {
        return $this->abos->groupBy('categorie_id')->map(function($keywords,$categorie_id){
            $published    = $this->published->contains('categorie_id',$categorie_id);
            // Make sure we have en empty collection if no keywords, so the repo has the categorie for searching in new decisions
            $keyword_list = !$keywords->isEmpty() ? $keywords->pluck('keywords_list') : collect([]);
            return ['keywords' => $keyword_list, 'published' => $published];
        });
    }

    public function getAbosApiAttribute()
    {
        return $this->abos->groupBy('categorie_id')->map(function($keywords,$categorie_id){
            $published    = $this->published->contains('categorie_id',$categorie_id);
            // Make sure we have en empty collection if no keywords, so the repo has the categorie for searching in new decisions
            $keyword_list = !$keywords->isEmpty() ? $keywords->pluck('keywords_list')->flatten(1) : collect([]);
            return ['keywords' => $keyword_list, 'published' => $published];
        });
    }

    public function scopeExclude($query, $exclude)
    {
        if($exclude && !empty($exclude)){
            $query->whereNotIn('id', $exclude);
        }
    }

    public function abos()
    {
        return $this->hasMany('App\Praticien\Abo\Entities\Abo');
    }

    public function published()
    {
        return $this->hasMany('App\Praticien\Abo\Entities\Abo_publish');
    }
}
