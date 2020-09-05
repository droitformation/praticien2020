<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Praticien\Arret\Repo\ArretInterface;
use App\Praticien\Theme\Repo\ThemeInterface;
use App\Praticien\Arret\Repo\MetaInterface;

class ArretController extends Controller
{
    protected $arret;
    protected $theme;
    protected $meta;

    public function __construct(ArretInterface $arret, ThemeInterface $theme, MetaInterface $meta)
    {
        $this->arret = $arret;
        $this->theme = $theme;
        $this->meta  = $meta;
    }

    public function index()
    {
        $parents = $this->theme->findParent(0);
        $arrets  = $this->arret->getNbr();
        $years   = $this->meta->getYears();

        list($arrets, $pending) = $arrets->partition(function ($arret) {
            return $arret->published_at < \Carbon\Carbon::today()->startOfDay()->toDateString();
        });

        return view('backend.arrets.index')->with(['arrets' => $arrets ,'pending' => $pending, 'parents' => $parents, 'years' => $years]);
    }

    public function create()
    {
        $editions = array_combine(range(date('Y')-1,2012),range(date('Y'),2013));

        return view('backend.arrets.create')->with(['editions' => $editions]);
    }

    public function year($year)
    {
        $arrets = $this->arret->byYear($year);

        return view('backend.arrets.edition')->with(['arrets' => $arrets, 'year' => $year]);
    }

    public function atf(Request $request)
    {
        $grab = new \App\Praticien\Bger\Utility\Liste();
        $url  = $grab->isAtfUrl($request->input('title'));

        return response()->json(['url' => $url ]);
    }
}
