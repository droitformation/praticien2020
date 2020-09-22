<?php namespace App\Praticien\User\Entities;

class Alert
{
    protected $user;
    protected $cadence;
    protected $date;

    public $decisions;
    public $publication_at;

    public function __construct($user,$cadence,$date)
    {
        $this->user    = $user;
        $this->cadence = $cadence;
        $this->date    = $date;
    }

    public function decisions()
    {
        $worker = \App::make('App\Praticien\Bger\Worker\AlertInterface');

        $this->publication_at = $this->cadence == 'weekly' ? weekRange($this->date)->toArray() : $this->date;

        $worker->setCadence($this->cadence)->setDate($this->publication_at);

        $this->decisions = $worker->getUserAbos($this->user);

        return $this;
    }

    public function html(){
        return (new \App\Mail\AlerteDecision($this->user, $this->publication_at, $this->decisions))->render();
    }

    public function status(){
        return $this->user->alerts->first(function ($alert, $key) {
            return $alert->publication_at->startOfDay()->toDateString() == $this->date;
        });
    }
}
