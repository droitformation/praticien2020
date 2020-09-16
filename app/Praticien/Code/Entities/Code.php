<?php namespace App\Praticien\Code\Entities;

use Illuminate\Database\Eloquent\Model;

class Code extends Model {

    protected $fillable = ['code','valid_at','user_id','updated_at'];
    protected $dates    = ['valid_at'];

    public function user()
    {
        return $this->belongsTo('App\Praticien\User\Entities\User');
    }

    public function getCanBeDeletedAttribute()
    {
        return !isset($this->user);
    }

    public function scopeYear($query, $year)
    {
        if(isset($year)){
            $query->whereYear('valid_at', $year);
        }
    }

}
