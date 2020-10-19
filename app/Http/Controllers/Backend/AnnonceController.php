<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Praticien\Newsletter\Repo\AnnonceInterface;

class AnnonceController extends Controller
{
    protected $annonce;

    public function __construct( AnnonceInterface $annonce)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');
        $this->annonce = $annonce;
    }

    public function store(Request $request)
    {
        $this->annonce->create($request->except('_token'));

        flash('Annonce crée','success');

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $this->annonce->update($request->except('_token'));

        flash('Annonce modifié','success');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->annonce->delete($id);

        flash('Annonce supprimée','success');

        return redirect()->back();
    }
}

