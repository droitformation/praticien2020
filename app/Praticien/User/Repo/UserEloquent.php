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

    public function convert(array $data){

        $user = $this->user->create(array(
            'id'           => $data['id'],
            'first_name'   => $data['first_name'] ?? null,
            'last_name'    => $data['last_name'] ?? null,
            'adresse'      => $data['adresse'] ?? null,
            'npa'          => $data['npa'] ?? null,
            'ville'        => $data['ville'] ?? null,
            'cadence'      => $data['cadence'] ?? null,
            'email'        => $data['email'],
            'password'     => $data['password'],
            'active_until' => $data['active_until'] ?? null,
            'created_at'   => date('Y-m-d G:i:s'),
            'updated_at'   => date('Y-m-d G:i:s')
        ));

        if( ! $user ) {
            return false;
        }

        /*
        '* abos' => [['categorie_id' => 244, 'keywords' => [["ATF 138 III 382"] ],'toPublish' => 1]]
         * */

        if(isset($data['abos'])){
            foreach ($data['abos'] as $abo){
                $insert = $user->abos()->create(['categorie_id' => $abo['categorie_id'], 'toPublish' => $abo['toPublish'] ?? null]);
                if(isset($abo['keywords']) && !empty($abo['keywords'])){
                    foreach ($abo['keywords'] as $keyword){
                        $insert->keywords()->create(['keywords' => $keyword]);
                    }
                }
            }
        }

        if(isset($data['role'])){
            $user->roles()->attach($data['role']);
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

        if(isset($data['role'])){
            $user->roles()->sync($data['role']);
        }

        return $user;
    }

    public function delete($id){

        $user = $this->user->find($id);

        return $user->delete($id);
    }

}
