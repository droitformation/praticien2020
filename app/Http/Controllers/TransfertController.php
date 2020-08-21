<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransfertController extends Controller
{
    // Posts => arrets
    public function posts()
    {
        $wordpress = \App::make('App\Praticien\Wordpress\Repo\PostRepo');
        $results = $wordpress->getAll();

        foreach ($results as $result){
            $arret = \App\Praticien\Wordpress\Convert\Arret::convert($result);

            $repo = \App::make('App\Praticien\Arret\Repo\ArretInterface');
            $repo->create($arret);
        }


        echo '<pre>';
        print_r('yes');
        echo '</pre>';
        exit;
    }

    // Categories => Themes
    public function themes()
    {
        $categories = \App\Praticien\Wordpress\Entities\Taxonomy::where('taxonomy', 'category')
            //->where('parent','=',0)
            ->where('count','>',0)
            ->get();

        $results = $categories->map(function ($categorie, $key) {
            $convert = \App\Praticien\Wordpress\Convert\Theme::convert($categorie);

            $repo = \App::make('App\Praticien\Theme\Repo\ThemeInterface');
            $repo->create($convert);
        });

        echo '<pre>';
        print_r('yes');
        echo '</pre>';
        exit;
    }

    // User + metas + abo => User + abo

}
