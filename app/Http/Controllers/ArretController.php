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
    }

    public function index()
    {
        $parents = $this->theme->findParent(0);

        return view('arrets.index')->with(['parents' => $parents]);
    }

    public function theme($slug)
    {
        $theme  = $this->theme->bySlug($slug);
        $arrets = $this->arret->byCategory($slug);

        return view('arrets.theme')->with(['theme' => $theme, 'arrets' => $arrets]);
    }

    public function subtheme($slug)
    {
        $subtheme = $this->theme->bySlug($slug);
        $theme    =  $subtheme->parent;
        $arrets   = $this->arret->byCategory($slug);

        return view('arrets.theme')->with(['theme' => $theme, 'arrets' => $arrets, 'subthemes' => $subtheme]);
    }
}
