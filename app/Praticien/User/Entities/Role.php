<?php namespace App\Praticien\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';
    protected $fillable = ['name','description'];

    /**
     * Set timestamps off
     */
    public $timestamps = false;
}
