<?php namespace App\Praticien\Decision\Worker;

use Illuminate\Support\Collection;

interface DecisionWorkerInterface
{
    public function setMissingDates(Collection $dates = null);
    public function getMissingDates();
    public function getExistingDates();
    public function update();
    public function insert($data);
}
