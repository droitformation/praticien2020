<?php namespace App\Praticien\Code\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model {

    use HasFactory,SoftDeletes;

    protected $fillable = ['code','valid_at','user_id','updated_at'];
    protected $dates    = ['valid_at'];

    protected static function newFactory()
    {
        return \Database\Factories\CodeFactory::new();
    }

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
