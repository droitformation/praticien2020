<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Praticien\Arret\Repo\ArretInterface;
use App\Praticien\Categorie\Repo\CategorieInterface;

class ArretController extends Controller
{
    protected $arret;
    protected $categorie;

    public function __construct(ArretInterface $arret, CategorieInterface $categorie)
    {
        $this->arret = $arret;
        $this->categorie = $categorie;
    }

    public function index()
    {
        $parents = $this->categorie->findParent(0);

        return view('arrets.index')->with(['parents' => $parents]);
    }

    public function categorie($slug)
    {
        $categorie = $this->categorie->bySlug($slug);
        $arrets    = $this->arret->byCategory($slug);

        return view('arrets.categorie')->with(['categorie' => $categorie, 'arrets' => $arrets]);
    }

    public function subcategorie($slug)
    {
        $subcategorie = $this->categorie->bySlug($slug);
        $categorie    =  $subcategorie->parent;
        $arrets       = $this->arret->byCategory($slug);

        return view('arrets.categorie')->with(['categorie' => $categorie, 'arrets' => $arrets, 'subcategories' => $subcategorie]);
    }
}
