<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Praticien\Arret\Repo\ArretInterface;

class SearchController extends Controller
{
    protected $arret;

    public function __construct(ArretInterface $arret)
    {
        $this->arret = $arret;
        view()->share('editions',array_combine(range(date('Y')-1,2008),range(date('Y'),2009)));
    }

    public function searchTerm(Request $request)
    {
        $arrets = $this->arret->searchTerm($request->input('term'));

        return view('arrets.results')->with(['arrets' => $arrets, 'term' => $request->input('term')]);
    }

    public function searchLoi(Request $request)
    {
        $arrets = $this->arret->searchLoi($request->input('params'),$request->input('year',null));

        return view('arrets.results')->with(['arrets' => $arrets, 'params' => $request->input('params')]);
    }
}
