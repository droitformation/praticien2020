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

    public function show($id,$year)
    {
        $decision = $this->decision->findArchive($id,$year);
        $dates    = $this->decision->getDateArchive($decision->publication_at->format('Y-m-d'));

        return view('backend.decisions.show')->with(['decision' => $decision, 'year' => $year, 'dates' => $dates]);
    }

    public function decisions($date,$year)
    {
        $dates = $this->decision->getDateArchive($date);

        return view('backend.decisions.show')->with(['year' => $year, 'dates' => $dates]);
    }

    public function archive($year = null)
    {
        $year      = $year ?? date('Y');
        $decisions = $this->decision->getYear($year);

        return view('backend.decisions.archive')->with(['decisions' => $decisions, 'year' => $year]);
    }

    public function search(Request $request)
    {
        $decision = $this->decision->findByNumero($request->input('numero'));

        return view('backend.decisions.show')->with(['decision' => $decision]);
    }

    public function transfert(Request $request)
    {
        $table = new \App\Praticien\Bger\Utility\Table();

        // Make archives
        $table->mainTable = 'decisions';

        $table->setYear( $request->input('year'))->canTransfert()->create()->transfertArchives();
        $table->deleteLastYear();

        flash('Année Archivé: '. $request->input('year'),'success');

        return redirect()->back();
    }
}
