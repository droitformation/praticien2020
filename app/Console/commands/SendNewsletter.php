<?php

namespace App\Console\commands;

use Illuminate\Console\Command;

class SendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter {test?} {date?}'; // php artisan send:newsletter true 2020-09-08

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly newsletter of arrets for publicationw';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $worker = \App::make('App\Praticien\Newsletter\Worker\NewsletterWorker');
        $url    = 'newsletter/preview';

        $date = $this->argument('date');

        $url = $date ? $url.'/'.$date : $url;

        $test = $this->argument('test');

        if(isset($test)){
             $worker->setUrl($url)->send_test();
        }
        else{
            $date = $date ? $date : null;
           // $result = $worker->setUrl($url)->setDate($date)->send();

            //\Log::info(json_encode($result));
        }
    }
}
