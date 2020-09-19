<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessKeywords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $publications_at;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($publication_at)
    {
        $this->publications_at = $publication_at;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $worker = \App::make('App\Praticien\Categorie\Worker\CategorieWorkerInterface');

        $worker->process($this->publications_at);
    }
}
