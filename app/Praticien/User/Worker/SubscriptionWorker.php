<?php namespace App\Praticien\User\Worker;

use App\Praticien\User\Repo\UserInterface;
use App\Praticien\Abo\Repo\AboInterface;

class SubscriptionWorker{

    protected $user;
    protected $subscription;

    public function __construct(UserInterface $user, AboInterface $subscription)
    {
        $this->user = $user;
        $this->subscription = $subscription;
    }

    public function update($user_id,$params)
    {
        $categorie_id = $params['categorie_id'] ?? null;
        $keywords     = $params['keywords'] ?? null;
        $toPublish    = $params['toPublish'] ?? null;

        $user = $this->user->find($user_id);
        $abo  = $user->abos->firstWhere('categorie_id','=',$categorie_id);

        if(!$abo){
            $abo = $this->subscription->create(['user_id' => $user_id, 'categorie_id' => $categorie_id, 'toPublish' => $toPublish]);
        }

        $abo->toPublish = $toPublish ? 1 : null;
        $abo->save();

        $abo->keywords->map(function ($keywords, $key) {
            return $keywords->delete();
        });;

        if(isset($keywords) && !empty($keywords)){
            foreach ($keywords as $keyword){
                $abo->keywords()->create(['keywords' => $keyword]);
            }
        }

        return $abo;
    }

    public function delete($user_id,$categorie_id)
    {
        $user = $this->user->find($user_id);
        $abo  = $user->abos->firstWhere('categorie_id','=',$categorie_id);

        if($abo){
            $abo->delete();
        }

        $user = $user->fresh();

        return $user;
    }
}
