<?php namespace App\Praticien\User\Repo;

use App\Praticien\User\Repo\UserInterface;
use App\Praticien\User\Entities\User as M;
use Illuminate\Support\Facades\Hash;

class UserEloquent implements UserInterface{

    protected $user;

    public function __construct(M $user)
    {
        $this->user = $user;
    }

    public function getAll(){

        return $this->user->all();
    }

    public function find($id){

        return $this->user->findOrFail($id);
    }

    public function findByEmail($email){

        return $this->user->whereEmail($email)->first();
    }

    public function getByCadence($cadence, $exclude = [])
    {
        return $this->user->has('abos')->with(['abos','published'])
            ->where('cadence','=',$cadence)
            ->whereDate('active_until', '>', \Carbon\Carbon::today()->startOfDay())
            ->exclude($exclude)
            ->get();
    }

    public function create(array $data){

        $user = $this->user->create(array(
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'adresse'    => $data['adresse'],
            'npa'        => $data['npa'],
            'ville'      => $data['ville'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'created_at' => date('Y-m-d G:i:s'),
            'updated_at' => date('Y-m-d G:i:s')
        ));

        if( ! $user ) {
            return false;
        }

        return $user;

    }

    public function update(array $data){

        $user = $this->user->findOrFail($data['id']);

        if( ! $user ) {
            return false;
        }

        $user->fill($data);

        if(!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->updated_at = date('Y-m-d G:i:s');
        $user->save();

        return $user;
    }

    public function delete($id){

        $user = $this->user->find($id);

        return $user->delete($id);
    }

}
