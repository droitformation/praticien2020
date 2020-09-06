<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Praticien\Arret\Repo\ArretInterface;
use App\Praticien\Theme\Repo\ThemeInterface;

class ArretController extends Controller
{
    protected $arret;
    protected $theme;

    public function __construct(ArretInterface $arret, ThemeInterface $theme)
    {
        $this->arret = $arret;
        $this->theme = $theme;

        view()->share('editions',array_combine(range(date('Y')-1,2010),range(date('Y'),2011)));
    }

    public function index()
    {
        $parents = $this->theme->findParent(0);

        return view('arrets.index')->with(['parents' => $parents]);
    }

    public function theme($slug,$edition = null)
    {
        $theme  = $this->theme->bySlug($slug);
        $arrets = $this->arret->byCategory($slug,$edition);

        return view('arrets.theme')->with(['theme' => $theme, 'arrets' => $arrets, 'edition' => $edition, 'slug' => 'subtheme']);
    }

    public function subtheme($slug,$edition = null)
    {
        $subtheme = $this->theme->bySlug($slug);
        $arrets   = $this->arret->byCategory($slug,$edition);

        $url = $edition ? $slug.'/'.$edition : $slug;

        return view('arrets.theme')->with(['theme' => $subtheme->parent, 'arrets' => $arrets, 'subtheme' => $subtheme, 'edition' => $edition, 'slug' => 'theme']);
    }
}
