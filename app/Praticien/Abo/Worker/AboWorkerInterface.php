<?php namespace App\Praticien\Abo\Worker;

interface AboWorkerInterface{
    public function make($data);
    public function remove($data);
}
