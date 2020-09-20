<?php namespace App\Praticien\Abo\Worker;

use App\Praticien\Abo\Worker\AboWorkerInterface;
use App\Praticien\Abo\Repo\AboInterface;

class AboWorker implements AboWorkerInterface
{
    protected $abo;

    public function __construct(AboInterface $abo)
    {
        $this->abo = $abo;
    }

    public function getByAbosCategory($user_id,$publication_at)
    {
        $decisions = $this->abo->getUserAbosForDate($user_id,$publication_at);

        return $decisions->groupBy('categorie_id')->mapWithKeys(function ($decision) {
            return [
                $decision->first()->categorie_id => $decision->pluck('decisions')->flatten(1)
            ];
        });
    }

    public function make($data)
    {
        // Delete everything
        $this->abo->delete($data); // user_id, categorie_id

        // Remake all
        if(isset($data['keywords']) && !empty($data['keywords'])){
            foreach ($data['keywords'] as $keyword){
                $this->abo->create([
                    'user_id'      => $data['user_id'],
                    'categorie_id' => $data['categorie_id'],
                    'keywords'     => $keyword
                ]);
            }
        }
        else{
            // Create abo for categorie with no keyword
            $this->abo->create(['user_id' => $data['user_id'], 'categorie_id' => $data['categorie_id'], 'keywords' => null]);
        }

        if(isset($data['published']) && $data['published'] == 1){
            $this->abo->publish($data['categorie_id'], $data['user_id']);
        }

        return true;
    }

    public function remove($data)
    {
        // Delete everything
        $this->abo->delete($data); // user_id, categorie_id

        return true;
    }
}
