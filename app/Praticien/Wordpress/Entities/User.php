<?php namespace App\Praticien\Wordpress\Entities;

use Illuminate\Database\Eloquent\Model;
use \Corcel\Model\User as Corcel;
use \Corcel\Model\Meta\UserMeta;

class User extends Corcel
{
    protected $fillable = ['ID'];

    public function abos()
    {
        return $this->hasMany('App\Praticien\Wordpress\Entities\UserAbo','refUser');
    }

    public function published()
    {
        return $this->hasMany('App\Praticien\Wordpress\Entities\UserAboPub','refUser');
    }
}
