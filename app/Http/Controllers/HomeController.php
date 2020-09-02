<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Praticien\User\Repo\UserInterface;
use App\Praticien\Categorie\Repo\CategorieInterface;

class HomeController extends Controller
{
    protected $user;
    protected $categorie;

    public function __construct(UserInterface $user, CategorieInterface $categorie)
    {
        $this->middleware('auth');

        $this->user = $user;
        $this->categorie = $categorie;
    }

    public function index()
    {
        return view('home')->with(['user' => \Auth::user()]);
    }

    public function abos()
    {
        $parents = $this->categorie->getParents();

        return view('abos')->with(['user' => \Auth::user()->load('abos','abos.keywords'), 'parents' => $parents->sortByDesc('rang')]);
    }

    public function cadence(Request $request)
    {
        $result = $this->user->update(['id' => $request->input('user_id'),'cadence' => $request->input('cadence')]);

        return response()->json(['result' => $request->all() ?? false]);
    }

    public function update(Request $request)
    {
        $user = $this->user->update($request->except(['_token']));

        flash('Informations mises a jour','success');

        return redirect('home');
    }
}
