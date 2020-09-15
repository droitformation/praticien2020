<?php namespace App\Praticien\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $table = 'annonces';
    protected $dates = ['start_at','end_at'];
    protected $fillable = ['title','content','link','start_at','end_at'];
}
