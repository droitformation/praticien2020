<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Praticien\Decision\Repo\DecisionInterface;
use App\Praticien\Decision\Worker\DecisionWorkerInterface;

class DecisionController extends Controller
{
    protected $decision;
    protected $worker;

    public function __construct(DecisionInterface $decision, DecisionWorkerInterface $worker)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        $this->decision = $decision;
        $this->worker = $worker;
    }

    public function index()
    {
        $liste = $this->worker->getMissingDates();
        $exist = $this->worker->getExistDatesArrets();
        $total = $this->decision->countByYear();

        return view('backend.decisions.index')->with(['liste' => $liste, 'exist' => $exist, 'total' => $total]);
    }

    public function archive($year = null)
    {
        $year      = $year ?? date('Y');
        $decisions = $this->decision->getYear($year);

        return view('backend.decisions.archive')->with(['decisions' => $decisions, 'year' => $year]);
    }
}
