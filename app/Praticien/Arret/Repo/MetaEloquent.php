<?php namespace App\Praticien\Arret\Repo;

use Zoha\Meta\Models\Meta as M;
use App\Praticien\Arret\Repo\MetaInterface;

class MetaEloquent implements MetaInterface
{
    protected $meta;

    public function __construct(M $meta)
    {
        $this->meta = $meta;
    }
    public function getYears(){

        $years = $this->meta->where('key','=','year')->select('value')->orderBy('value','DESC')->get();

        return $years->groupBy('value')->map(function ($item) {
            return $item->count();
        });
    }
}
