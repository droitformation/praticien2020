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
    }

    public function index(Request $request)
    {
        $params = $request->except(['_token']);

     /*  echo '<pre>';
        print_r($params);
        echo '</pre>';
        exit;*/
        //$params['terms']
        //$params['published']
        //$params['period']0 start, 1 end
        //$params['categorie_id']

        $decisions = empty(array_filter($params)) ? $this->decision->getAll() : $this->decision->searchArchives(array_filter($params));
        $parents   = $this->categorie->getParents();

        return view('decisions.index')->with(['parents' => $parents, 'decisions' => $decisions]);
    }

    public function show($slug)
    {
        $categorie  = $this->categorie->bySlug($slug);
        $decisions = $this->decision->byCategory($slug);

        return view('decisions.categorie')->with(['categorie' => $categorie, 'decisions' => $decisions]);
    }

}
