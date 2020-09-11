<?php namespace App\Http\Controllers\Backend;

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

        return view('backend.users.index')->with(['users' => $users, 'params' => $request->except('_token'), 'alert' => $alert ?? null]);
    }

    public function show($d)
    {
        $user = $this->user->find($d);

        return view('backend.users.show')->with(['user' => $user]);
    }

    public function inactive(Request $request)
    {
        $users = $this->user->getInActives();

        return view('backend.users.inactive')->with(['users' => $users, 'params' => $request->except('_token'), 'alert' => $alert ?? null]);
    }

    public function alerte(Request $request)
    {
        $alertes = [];

        $users = $this->user->getActiveWithAbos();

        $date     = $request->input('date') ? $request->input('date') : \Carbon\Carbon::today()->toDateString();
        $users_id = $request->input('user_id') ? [$request->input('user_id')] : $users->pluck('id')->all();

        foreach($users_id as $id){
            $user      = $this->user->find($id);
            $cadence   = $request->input('cadence') ? $request->input('cadence') : $user->cadence;

            $alertes[] = \App\Praticien\User\Entities\Alert::view($user,$cadence,$date);
        }

        $users = $this->user->getActiveWithAbos();

        return view('backend.users.alertes')->with(['users' => $users, 'params' => $request->except('_token'), 'alertes' => array_filter($alertes)]);
    }
}


