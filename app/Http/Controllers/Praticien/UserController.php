<?php

namespace App\Http\Controllers\Praticien;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Praticien\User\Worker\UserWorkerInterface;
use App\Praticien\User\Repo\UserInterface;
use App\Praticien\Bger\Worker\AlertInterface;

class UserController extends Controller
{
    protected $worker;
    protected $user;

    public function __construct(UserWorkerInterface $worker, UserInterface $user)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        $this->worker = $worker;
        $this->user   = $user;
    }

    public function index(Request $request)
    {
        if($request->input('user_id')){
            $user  = $this->user->find($request->input('user_id'));
            $alert = \App\Praticien\User\Entities\Alert::view($user,$request->input('cadence'),$request->input('date'));
        }

        $users = $this->user->getActives();

        return view('backend.users')->with(['users' => $users, 'params' => $request->except('_token'), 'alert' => $alert ?? null]);
    }
}


