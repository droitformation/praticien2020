<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Praticien\User\Repo\UserInterface;
use App\Praticien\Code\Repo\AnnonceInterface;
use Illuminate\Validation\Rule;
use Validator;

class CodeController extends Controller
{
    protected $user;
    protected $code;

    public function __construct(UserInterface $user, AnnonceInterface $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    public function expired()
    {
        return view('pages.expired');
    }

    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => [
                'required', Rule::exists('codes')->where(function ($query) {$query->whereNull('user_id')->where('valid_at','>=',date('Y-m-d'));
                }),
            ]
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors()->toArray())->map(function ($error, $key) {
                return $error[0];
            })->implode('<br>');

            flash($errors,'danger');

            return redirect('expired')->withErrors($validator)->withInput();
        }

        if (\Auth::attempt($request->only('email', 'password'))) {
            $user = \Auth::user();
            $code = $this->code->updateCode($request->input('code'), $user->id);
            $user->active_until = $code->valid_at;
            $user->save();

            flash('Votre compte a été réactivé','success');

            return redirect('home');
        }

        return redirect('login');
    }
}
