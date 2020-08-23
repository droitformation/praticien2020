<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $decisions = $this->decision->getAll();

        return response()->json([
            "draw"            => $request->input('draw'),
            "start"           => $request->input('start'),
            "length"          => $request->input('length'),
            "recordsTotal"    => $this->decision->count(),
            "recordsFiltered" => $decisions->count(),
            'data' => $decisions->map(function ($decision) {
                return [
                    'id'             => $decision->id,
                    'publication_at' => $decision->publication_at->format('d/m/Y'),
                    'decision_at'    => $decision->decision_at->format('d/m/Y'),
                    'numero'         => $decision->numero,
                    'categorie'      => $decision->categorie->name.'<br>'.$decision->remarque,
                    'lang'           => $decision->lang,
                    'publish'        => $decision->publish ? '<i class="fas fa-check"></i>' : '',
                ];
            })
        ]);
    }
}
