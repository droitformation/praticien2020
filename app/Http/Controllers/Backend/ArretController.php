<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Praticien\Arret\Repo\ArretInterface;
use App\Praticien\Theme\Repo\ThemeInterface;
use App\Praticien\Arret\Repo\MetaInterface;
use App\Http\Requests\ArretCreateRequest;
use App\Http\Requests\ArretUpdateRequest;

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

        view()->share('editions',array_combine(range(date('Y')-1,2008),range(date('Y'),2009)));

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
        $themes   = $this->theme->getParents();
        $themes   = $themes->map(function ($theme) {
            return ['id' => $theme->id, 'text' => $theme->name, 'subthemes' => $theme->subthemes->map(function ($subtheme) {
                return ['id' => $subtheme->id, 'text' => $subtheme->name];
            })->toArray()];
        });

        return view('backend.arrets.create')->with(['themes' => $themes]);
    }

    public function store(ArretCreateRequest $request)
    {
        $prepared = \App\Praticien\Arret\Entities\Prepare::prepare($request->except('_token'));
        $arret    = $this->arret->create($prepared);

        flash('Arrêt crée','success');

        return redirect('backend/arret/'.$arret->id);
    }

    public function show($id)
    {
        $arret    = $this->arret->find($id);
        $themes   = $this->theme->getParents();
        $themes   = $themes->map(function ($theme) {
            return ['id' => $theme->id, 'text' => $theme->name, 'subthemes' => $theme->subthemes->map(function ($subtheme) {
                return ['id' => $subtheme->id, 'text' => $subtheme->name];
            })->toArray()];
        });

        return view('backend.arrets.show')->with(['arret' => $arret, 'themes' => $themes]);
    }

    public function update(ArretUpdateRequest $request)
    {
        $prepared = \App\Praticien\Arret\Entities\Prepare::prepare($request->except('_token'));
        $arret    = $this->arret->update($prepared);

        flash('Arrêt mis à jour','success');

        return redirect('backend/arret/'.$arret->id);
    }

    public function year($year)
    {
        $arrets = $this->arret->byYear($year);

        return view('backend.arrets.edition')->with(['arrets' => $arrets, 'year' => $year]);
    }

    public function atf(Request $request)
    {
        $url = \App\Praticien\Arret\Entities\Atf::url($request->input('title'));

        return response()->json(['url' => $url]);
    }
}
