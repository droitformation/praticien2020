<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessage;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function index()
    {
        return view('pages.index');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function access()
    {
        return view('pages.access');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendMessage(SendMessage $request){

        \Mail::to(config('mail.from.address'))->send(new \App\Mail\ContactMessage($request->only(['email','nom','remarque'])));

        flash('Merci pour votre message! nous vous répondrons dans les plus brefs délais.')->success();

        return redirect()->back();
    }
}
