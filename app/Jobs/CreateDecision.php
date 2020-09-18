<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateDecision implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $decision;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $decision)
    {
        $this->decision = $decision;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repo      = \App::make('App\Praticien\Decision\Repo\DecisionInterface');
        $categorie = \App::make('App\Praticien\Categorie\Worker\CategorieWorkerInterface');
        $failed    = \App::make('App\Praticien\Decision\Repo\FailedInterface');

        $worker = new \App\Praticien\Bger\Utility\Decision();

        $data = $worker->setDecision($this->decision)->getArret();

        if($data){
            $new = $repo->create($data);
            // test if decision with keywords for droit des avocats
            $categorie->process($new);
        }
        else{
            $failed->create(['publication_at' => $data['publication_at'], 'numero' => $data['numero']]);
        }
    }
}
