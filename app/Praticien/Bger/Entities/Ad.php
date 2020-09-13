<?php namespace App\Praticien\Bger\Entities;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ads';
    protected $dates = ['start_at','end_at'];
    protected $fillable = ['title','content','link','start_at','end_at'];
}
