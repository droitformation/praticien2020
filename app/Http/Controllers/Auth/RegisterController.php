<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Praticien\User\Entities\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Praticien\Code\Repo\CodeInterface;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $code;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CodeInterface $code)
    {
        $this->code = $code;

        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'adresse'    => ['required', 'string', 'max:255'],
            'npa'        => ['required', 'string', 'max:255'],
            'ville'      => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                Rule::exists('codes')->where(function ($query) {
                    $query->whereNull('user_id')->where('valid_at','>=',date('Y-m-d'));
                }),
            ],
        ],[
            'code.required' => 'Le code n\'est pas valide'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'adresse'    => $data['adresse'],
            'npa'        => $data['npa'],
            'ville'      => $data['ville'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);

        // Deactivate code used
        $code = $this->code->updateCode($data['code'], $user->id);
        $user->roles()->attach(2); // Abonne

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return redirect('home')->with(['status' => 'success', 'message' => 'Vous êtes bien inscrit!']);
    }
}
