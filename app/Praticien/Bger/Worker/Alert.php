<?php namespace App\Praticien\Bger\Worker;

use App\Praticien\Bger\Worker\AlertInterface;
use App\Praticien\Decision\Repo\DecisionInterface;
use App\Praticien\User\Repo\UserInterface;
use App\Praticien\Abo\Worker\AboWorkerInterface;

class Alert implements AlertInterface
{
    protected $decision;
    protected $user;
    protected $cadence;
    protected $abo;

    public $publication_at;

    public function __construct(DecisionInterface $decision, UserInterface $user, AboWorkerInterface $abo)
    {
        $this->decision = $decision;
        $this->user     = $user;
        $this->abo      = $abo;
    }

    /**
     * @param mixed $cadence
     */
    public function setCadence($cadence)
    {
        $this->cadence = $cadence;

        return $this;
    }

    /**
     * @param mixed $publication_at
     */
    public function setDate($publication_at)
    {
        $this->publication_at = $publication_at;

        return $this;
    }

    /**
     * @param mixed $publication_at
     */
    public function getDate()
    {
        // copy date else the last one is deleted
        $date = $this->publication_at;

        return !is_array($date) ? $date : array_pop($date);
    }

    public function getUsers()
    {
        // get all user without those we already sent something => getByCadence(cadence, exclude id user)
        $already = $this->alertAlreadySent();
        $users   = $this->user->getByCadence($this->cadence, $already->pluck('user_id')->toArray());

        return $users->map(function($user){
            // Search in new decisisions of the day or week
            return ['user' => $user, 'abos' => $this->getUserAbos($user)];
        })->reject(function($item){
            // Reject if no decisions found
            return $item['abos']->isEmpty();
        });
    }

    public function getAbos($user_id){
        return $this->abo->getByAbosCategory($user_id,$this->publication_at);
    }

    /*
   public function getUserAbos($user)
   {
       $decisions = $this->getAbos($user->id,$this->publication_at);

       $k = $decisions->map(function ($abo,$categorie_id) use ($user) {

           $list = $user->abonnements[$categorie_id] ?? null;
           if($list){}

           $keywords  = $list['keywords'];
           $published = $list['published'] > 0 ? 1 : 0;

           return $keywords->map(function($keyword) use ($categorie_id,$published,$abo){
               // Find decisions for categories published or not
               $keyword = isset($keyword) && !$keyword->isEmpty() ? array_filter($keyword->toArray()) : null;
               // don't search for général categorie if no keywords
               if(!$keyword && $categorie_id == 247){return collect([]);}
               return $this->findDecision($keyword,$categorie_id,$published,$abo->pluck('id')->all());
           })->reject(function($item){
               // Reject if no decisions found
               return $item->isEmpty();
           })->flatten(1);

       });

       echo '<pre>';
       print_r();
       echo '</pre>';
       exit;
          ->reject(function($item){
               // Reject if no decisions found
               return $item->isEmpty();
           })  ->map(function ($item) {
           return [
               'decision'  => $item->first(),
               'categorie' => $item->first()->categorie_id,
               'keywords'  => $item->pluck('keywords')->flatten()->implode(', '),
           ];
       });
   }*/

    public function getUserAbos($user)
    {
        return $user->abonnements->map(function($list,$categorie_id){
            // list keys: keywords => collection, published => bool
            $keywords  = $list['keywords'];
            $published = $list['published'] > 0 ? 1 : 0;

            return $keywords->map(function($keyword) use ($categorie_id,$published){
                // Find decisions for categories published or not
                $keyword = isset($keyword) && !$keyword->isEmpty() ? array_filter($keyword->toArray()) : null;

                // don't search for général categorie if no keywords
                if(!$keyword && $categorie_id == 247){return collect([]);}

                return $this->findDecision($keyword,$categorie_id,$published);

            })->reject(function($item){
                // Reject if no decisions found
                return $item->isEmpty();
            });
        })->flatten()->groupBy('id')->map(function ($item, $key) {
            return [
                'decision'  => $item->first(),
                'categorie' => $item->first()->categorie_id,
                'keywords'  => $item->pluck('keywords')->flatten()->unique()->reject(function($item){
                    return !$item;
                })->implode(', '),
            ];
        });
    }

    public function findDecision($keyword,$categorie_id,$published)
    {
        $decisions = $this->decision->search([
            'terms'          => $keyword,
            'categorie'      => $categorie_id,
            'published'      => $published,
            'publication_at' => $this->publication_at
        ]);

        return $decisions->map(function ($item, $key) use ($categorie_id,$keyword) {
            $item = $item->setAttribute( 'keywords', $keyword);
            return $item;
        });
    }

    public function sent($abo){

        return \App\Praticien\Bger\Entities\Alert_sent::create(['user_id' => $abo->id, 'publication_at' => $this->getDate()]);
    }

    public function alertAlreadySent(){

        return \App\Praticien\Bger\Entities\Alert_sent::whereDate('publication_at', $this->getDate())->get();
    }
}
