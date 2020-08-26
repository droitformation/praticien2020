<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Praticien\User\Repo\UserInterface;
use App\Praticien\Categorie\Repo\CategorieInterface;

class SubscribeController extends Controller
{
    protected $user;
    protected $categorie;

    public function __construct(UserInterface $user, CategorieInterface $categorie)
    {
        $this->middleware('auth');

        $this->user = $user;
        $this->categorie = $categorie;
    }

    public function subscribe(Request $request)
    {
        //['categorie_id' => 244, 'keywords' => [["ATF 138 III 382"]],'toPublish' => 1]
        $user = $this->user->update(['id' => $request->input('id'), 'abos' => [$request->input('abos')]]);

        return response()->json(['abos' => $user->abos->where('categorie_id', $request->input('abos.categorie_id'))]);
    }

    public function unsubscribe(Request $request)
    {

    }
}
