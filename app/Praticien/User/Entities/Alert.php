<?php namespace App\Praticien\User\Entities;

class Alert
{
    protected $user;
    protected $cadence;
    protected $date;

    public function __construct($user,$cadence,$date)
    {
        $this->user    = $user;
        $this->cadence = $cadence;
        $this->date    = $date;
    }

    public function html(){

        $worker = \App::make('App\Praticien\Bger\Worker\AlertInterface');

        $date = $this->cadence == 'weekly' ? weekRange($this->date)->toArray() : $this->date;

        $worker->setCadence($this->cadence)->setDate($date);

        $decisions = $worker->getUserAbos($this->user);

        return !$decisions->isEmpty() ? (new \App\Mail\AlerteDecision($this->user, $date, $decisions))->render() : null;
    }

    public function status(){
        return $this->user->alerts->first(function ($alert, $key) {
            return $alert->publication_at->startOfDay()->toDateString() == $this->date;
        });
    }
}
