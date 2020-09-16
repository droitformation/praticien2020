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
        $year = $year ? $year : date('Y');
        $codes = $this->code->getAll($year);
        $years = $this->code->years();

        return view('backend.codes.index')->with(['codes' => $codes, 'years' => $years]);
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
        $this->code->make($request->input('nbr'),$request->except(['_token','nbr']));

        flash('Code crée','success');

        return redirect('backend/code');
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

    public function export(Request $request)
    {
        return \Excel::download(new \App\Exports\CodesExport($request->input('year')), 'codes_'.$request->input('year').'.xlsx');
    }
}
