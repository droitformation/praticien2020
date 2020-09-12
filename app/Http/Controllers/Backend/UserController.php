<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Praticien\User\Worker\UserWorkerInterface;
use App\Praticien\User\Repo\UserInterface;
use App\Praticien\Bger\Worker\AlertInterface;
use App\Praticien\Code\Repo\CodeInterface;

class UserController extends Controller
{
    protected $worker;
    protected $user;
    protected $code;

    public function __construct(UserWorkerInterface $worker, UserInterface $user, CodeInterface $code)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        $this->worker = $worker;
        $this->user   = $user;
        $this->code   = $code;
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

    public function show($id)
    {
        $user = $this->user->find($id);

        return view('backend.users.show')->with(['user' => $user]);
    }

    public function inactive()
    {
        $users = $this->user->getInActives();

        return view('backend.users.inactive')->with(['users' => $users, 'alert' => $alert ?? null]);
    }

    public function code(Request $request)
    {
        $user = $this->user->find($request->input('id'));
        $code = $this->code->valid($request->input('code'));

        if($code){
            $code = $this->code->updateCode($request->input('code'), $user->id);
            $user->active_until = $code->valid_at;
            $user->save();

            flash('Code appliqué','success');
        }
        else{
            flash('Code non valide','danger');
        }

        return redirect('backend/user/'.$user->id);
    }

    public function update($id, Request $request)
    {
        $user = $this->user->update($request->except('_token'));

        flash('Utilisateur mis à jour','success');

        return redirect()->back();
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


