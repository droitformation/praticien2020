<?php namespace App\Praticien\Wordpress\Entities;

use Illuminate\Database\Eloquent\Model;

class UserAboPub extends Model
{
    protected $table = 'user_abo_pub';
    protected $connection = 'wordpress';
    protected $fillable = ['refUser','refCategorie','ispub'];

}
