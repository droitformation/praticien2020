<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Praticien\Decision\Repo\DecisionInterface;
use App\Praticien\Categorie\Repo\CategorieInterface;

class DecisionController extends Controller
{
    protected $decision;
    protected $categorie;

    public function __construct(DecisionInterface $decision, CategorieInterface $categorie)
    {
        $this->decision  = $decision;
        $this->categorie = $categorie;

        view()->share('parents',$this->categorie->getParents());
    }

    public function index(Request $request)
    {
        if($request->input('clear')){
            session()->forget('search');
        }

        $params = addDates($request->all());

        if($this->hasInput($request)){
            session()->put('search',$params);
        }

        if(session()->has('search')){
            $params = session()->get('search');
        }

        $decisions = $this->decision->searchArchives($params);
        $parents   = $this->categorie->getParents();

        return view('decisions.table')->with(['decisions' => $decisions, 'params' => $params]);
    }

    public function show($id,$year)
    {
        $decision = $this->decision->findArchive($id,$year);

        return view('decisions.show')->with(['decision' => $decision]);
    }

    public function categorie($id, Request $request)
    {
        if($request->input('clear')){session()->forget('search');}

        $params = addDates($request->all());

        if($this->hasInput($request)){session()->put('search',$params);}
        if(session()->has('search')){$params = session()->get('search');}

        $params['categorie_id'] = $id;

        $categorie = $this->categorie->find($id);
        $decisions = $this->decision->searchArchives($params);

        return view('decisions.categorie')->with(['categorie' => $categorie, 'decisions' => $decisions, 'params' => $params]);
    }

    public function export($id)
    {
        $decision = $this->decision->find($id);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        \PhpOffice\PhpWord\Settings::setTempDir(storage_path('temp'));

        $section = $phpWord->addSection();

        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setName('Arial');
        $fontStyle->setSize(14);

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $decision->texte, false, true);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {

            $objWriter->save(storage_path($decision->numero.'.docx'));

        } catch (Exception $e) {

        }

        return response()->download(storage_path($decision->numero.'.docx'));

    }
}
