<?php namespace App\Praticien\User\Entities;

class Alert
{
    static function view($user,$cadence,$date){

        $worker = \App::make('App\Praticien\Bger\Worker\AlertInterface');

        $date = $cadence == 'weekly' ? weekRange($date)->toArray() : $date;

        $worker->setCadence($cadence)->setDate($date);
        $data = $worker->getUserAbos($user);

        return (new \App\Mail\AlerteDecision($user, $date, $data))->render();
    }
}
