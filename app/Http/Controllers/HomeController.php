<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Praticien\User\Repo\UserInterface;

class HomeController extends Controller
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->middleware('auth');

        $this->user = $user;
    }

    public function index()
    {
        return view('home')->with(['user' => \Auth::user()]);
    }

    public function cadence(Request $request)
    {
        $result = $this->user->update(['id' => $request->input('user_id'),'cadence' => $request->input('cadence')]);

        return response()->json(['result' => $request->all() ?? false]);
    }
}
