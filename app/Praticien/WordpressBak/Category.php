<?php namespace App\Praticien\Wordpress;

use Illuminate\Support\Facades\DB;

class Category
{
    public function getCategories()
    {
        //return DB::connection('wordpress')->table('wp_terms')->get();
        return DB::connection('wordpress')
            ->table('wp_terms')
            ->join('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id', 'left')
            ->where('wp_term_taxonomy.taxonomy','=','category')
            ->where('wp_term_taxonomy.count','>',0)->get();
    }

    public function categorie($id)
    {
        return DB::connection('wordpress')
            ->table('wp_terms')
            ->join('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id', 'left')
            ->where('wp_term_taxonomy.taxonomy','=','category')
            ->where('wp_term_taxonomy.parent','=',$id)
            ->where('wp_term_taxonomy.count','>',0)
            ->get( );
    }

    public function getTree($rootid)
    {
        $arr = [];

        $result = $this->categorie($rootid);

        foreach ($result as $row) {
            $arr[] = array(
                "id"       => $row->term_id,
                "name"     => $row->name,
                "children" => $this->getTree($row->term_id)
            );
        }

        return $arr;
    }
}
