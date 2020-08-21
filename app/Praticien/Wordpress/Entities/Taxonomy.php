<?php namespace App\Praticien\Wordpress\Entities;

use Illuminate\Database\Eloquent\Model;
use \Corcel\Model\Taxonomy as Corcel;

class Taxonomy extends Corcel
{
    function theparent()
    {
        return $this->belongsTo(Taxonomy::class, 'parent','term_id');
    }

    public function children()
    {
        return $this->hasMany('App\Praticien\Wordpress\Entities\Taxonomy', 'parent', 'term_id')
            ->join('terms', 'term_taxonomy.term_id', '=', 'terms.term_id')
            ->orderBy('terms.name','ASC');
    }

    public function allChildrenAccounts()
    {
        return $this->children()->with('allChildrenAccounts');
    }
}
