<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Praticien\Theme\Repo\ThemeInterface;

class ThemeController extends Controller
{
    protected $theme;

    public function __construct(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    public function index()
    {
        $themes = $this->theme->getAll();

        return view('backend.themes.index')->with(['themes' => $themes]);
    }

    public function create()
    {
        $parents = $this->theme->findParent(0);

        return view('backend.themes.create')->with(['parents' => $parents]);
    }

    public function store(Request $request)
    {
        $theme = $this->theme->create($request->only('name'));

        if($request->ajax()){
            return response()->json($theme);
        }

        flash('Domaine crée','success');

        return redirect('backend/theme/'.$theme->id);
    }

    public function show($id)
    {
        $parents = $this->theme->findParent(0);
        $theme   = $this->theme->find($id);

        return view('backend.themes.show')->with(['theme' => $theme, 'parents' => $parents]);
    }

    public function update($id, Request $request)
    {
        $theme = $this->theme->update($request->except('_token'));

        flash('Domaine mis à jour','success');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->theme->delete($id);

        flash('Le domaine a été supprimé','success');

        return redirect('backend/theme');
    }

}
