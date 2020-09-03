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
        'id','first_name','last_name', 'email', 'password', 'adresse','npa','ville','cadence','active_until'
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

    public function getNameAttribute()
    {
        return !empty(trim($this->first_name)) || !empty(trim($this->last_name)) ? trim($this->first_name.' '.$this->last_name) : $this->email;
    }

    public function getRoleAttribute()
    {
       if($this->roles->contains('id',1)){
            return 'Administrateur';
       }

        if($this->roles->contains('id',2)){
            return 'Contributeur';
        }

        if($this->roles->contains('id',3)){
            return 'Abonné';
        }
    }

    public function getValidAttribute()
    {
        return $this->active_until > \Carbon\Carbon::today()->startOfDay();
    }

    public function getAbonnementsAttribute()
    {
        return $this->abos->mapWithKeys(function($abo,$key){
            // Make sure we have en empty collection if no keywords, so the repo has the categorie for searching in new decisions
            $keywords = $abo->keywords->map(function ($keyword) {
                return $keyword->keywords_list;
            })->flatten();

            return [
                $abo->categorie_id => [
                    'keywords'  => collect([$keywords]),
                    'published' => $abo->toPublish
                ]
            ];
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
        return $this->hasMany('\App\Praticien\Abo\Entities\Abo');
    }

    public function codes()
    {
        return $this->hasMany('\App\Praticien\Code\Entities\Code');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Praticien\User\Entities\Role', 'user_roles', 'user_id', 'role_id');
    }
}
