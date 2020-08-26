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
        $data = [
            'categorie_id' => $request->input('categorie_id'),
            'keywords'     => array_flatten(array_values($request->input('keywords'))),
            'toPublish'    => $request->input('toPublish'),
        ];

        //['categorie_id' => 244, 'keywords' => [["ATF 138 III 382"]], 'toPublish' => 1]
        $user = $this->user->update(['id' => $request->input('user_id'), 'abos' => [$data]]);

        return response()->json(['abos' => getAboCategorie($user,$request->input('categorie_id'))]);
    }

    public function unsubscribe(Request $request)
    {

    }
}
