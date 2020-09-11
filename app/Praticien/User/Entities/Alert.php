<?php namespace App\Praticien\User\Entities;

class Alert
{
    static function view($user,$cadence,$date){

        $worker = \App::make('App\Praticien\Bger\Worker\AlertInterface');

        $date = $cadence == 'weekly' ? weekRange($date)->toArray() : $date;

        $worker->setCadence($cadence)->setDate($date);
        $decisions = $worker->getUserAbos($user);

        return !$decisions->isEmpty() ? (new \App\Mail\AlerteDecision($user, $date, $decisions))->render() : null;
    }
}
