<?php

namespace App\Praticien\Abo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Abo_keyword extends Model
{
    use HasFactory;

    protected $table = 'abo_keywords';
    public $timestamps = false;

    protected $fillable = [
        'abo_id', 'keywords'
    ];

    protected static function newFactory()
    {
        return \Database\Factories\AboKeywordFactory::new();
    }

    public function getKeywordsListAttribute()
    {
        $search = htmlspecialchars_decode($this->keywords);

        $output = preg_split( "/(,|;)/", $search );
        return collect($output)->groupBy(function ($item, $key) {
            return preg_match('/\"([^\"]*?)\"/', $item, $m) ? 'quotes' : 'noquotes';
        })->map(function ($items, $key) {
            return $items->map(function ($item, $key) {
                return trim(str_replace('"', '', $item));
            });
        })->flatten();
    }

}
