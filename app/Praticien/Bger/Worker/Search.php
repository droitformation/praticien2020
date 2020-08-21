<?php namespace App\Praticien\Bger\Worker;

use App\Praticien\Bger\Worker\SearchInterface;
use App\Praticien\Decision\Repo\DecisionInterface;
use App\Praticien\Bger\Utility\Clean;

class Search implements SearchInterface
{
    protected $clean;
    protected $decision;

    public function __construct(DecisionInterface $decision, Clean $clean)
    {
        $this->decision = $decision;
        $this->clean    = $clean;
    }

    public function all($search)
    {

    }
}
