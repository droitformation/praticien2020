<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Praticien\Code\Repo\CodeInterface;

class CodeController extends Controller
{
    protected $code;

    public function __construct(CodeInterface $code)
    {
        $this->code = $code;
    }

    public function index($year = null)
    {
        $codes = $this->code->getAll($year);

        return view('backend.codes.index')->with(['codes' => $codes]);
    }

    public function newcode()
    {
        return response()->json(['code' => $this->code->newCode()]);
    }

    public function create()
    {
        return view('backend.codes.create');
    }

    public function store(Request $request)
    {
        $code = $this->code->create($request->except('_token'));

        flash('Code crée','success');

        return redirect('backend/code/'.$code->id);
    }

    public function show($id)
    {
        $code = $this->code->find($id);

        return view('backend.codes.show')->with(['code' => $code]);
    }

    public function update(Request $request, $id)
    {
        $code = $this->code->update($request->except('_token'));

        flash('Code mis à jour','success');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->code->delete($id);

        flash('Le code a été supprimé','success');

        return redirect('backend/codes');
    }
}
