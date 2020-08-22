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

    public function index()
    {
        $decisions = $this->decision->getAll();

        return view('decisions.index')->with(['decisions' => $decisions]);
    }

    public function show($slug)
    {
        $categorie  = $this->categorie->bySlug($slug);
        $decisions = $this->decision->byCategory($slug);

        return view('decisions.categorie')->with(['categorie' => $categorie, 'decisions' => $decisions]);
    }

}
