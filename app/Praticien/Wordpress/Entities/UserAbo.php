<?php namespace App\Praticien\Wordpress\Entities;

use Illuminate\Database\Eloquent\Model;

class UserAbo extends Model
{
    protected $table = 'user_abo';
    protected $connection = 'wordpress';
    protected $fillable = ['id_abo','refUser','refCategorie','keywords'];


}
