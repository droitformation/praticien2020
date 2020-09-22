<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Praticien\User\Worker\UserWorkerInterface;
use App\Praticien\User\Repo\UserInterface;
use App\Praticien\Bger\Worker\AlertInterface;
use App\Praticien\Code\Repo\CodeInterface;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function index()
    {
        $users = $this->user->getActives();

        return view('backend.users.index')->with(['users' => $users]);
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function show($id)
    {
        $user = $this->user->find($id);

        return view('backend.users.show')->with(['user' => $user]);
    }

    public function store(Request $request)
    {
        $user = $this->user->create(array_filter($request->except('_token')));

        flash('Utilisateur crée','success');

        return redirect('backend/user/'.$user->id);
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
        $user = $this->user->update(array_filter($request->except('_token')));

        flash('Utilisateur mis à jour','success');

        return redirect()->back();
    }

    public function alerte(Request $request)
    {
        $alertes = collect([]);

        $actives = $this->user->getActiveWithAbos($cadence = null);

        $date     = $request->input('date') ? $request->input('date') : \Carbon\Carbon::today()->toDateString();
        $users_id = $request->input('user_id') ? [$request->input('user_id')] : $actives->pluck('id')->all();
        $cadence  = $request->input('cadence','daily');

        $alertes = collect($users_id)->map(function ($id, $key) use ($date,$cadence){
            $user      = $this->user->find($id);
            $cadence   = $cadence ?? $user->cadence;
            $alert     = new \App\Praticien\User\Entities\Alert($user,$cadence,$date);
            return $alert->decisions();
        });

        $users = $this->user->getActive();

        return view('backend.users.alertes')->with(['users' => $users, 'params' => $request->except('_token'), 'alertes' => $alertes]);
    }

    public function destroy($id)
    {
        $this->user->delete($id);

        flash('L\'utilisateur été supprimé','success');

        return redirect('backend/user');
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}


