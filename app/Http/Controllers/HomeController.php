<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Praticien\Api\UserApi;

class HomeController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');

        $api  = new UserApi();
        $this->user = $api->getUser(15);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with(['user' => $this->user]);
    }
}
