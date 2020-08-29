<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Praticien\User\Repo\UserInterface;
use App\Praticien\Categorie\Repo\CategorieInterface;
use App\Praticien\User\Worker\SubscriptionWorker;

class SubscribeController extends Controller
{
    protected $user;
    protected $categorie;
    protected $worker;

    public function __construct(UserInterface $user, CategorieInterface $categorie, SubscriptionWorker $worker)
    {
        $this->middleware('auth');

        $this->user = $user;
        $this->categorie = $categorie;
        $this->worker = $worker;
    }

    public function subscribe(Request $request)
    {
        $data = [
            'categorie_id' => $request->input('categorie_id'),
            'keywords'     => array_flatten(array_values($request->input('keywords'))),
            'toPublish'    => $request->input('toPublish'),
        ];

        $abo = $this->worker->update($request->input('user_id'), $data);

        return response()->json(['abo' => $abo]);
    }

    public function unsubscribe(Request $request)
    {
        $this->worker->delete($request->input('user_id'),$request->input('categorie_id'));

        return response()->json(['result' => true]);
    }
}
