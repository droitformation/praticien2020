<?php namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CodesExport implements FromCollection,WithHeadings
{
    protected $repo;
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
        $this->repo = \App::make('App\Praticien\Code\Repo\CodeInterface');
    }

    public function headings(): array {
        return ['Code','Date de validité','Utilisé','Utilisateur'];
    }

    public function collection()
    {
        return $this->repo->getAll($this->year)->map(function ($code) {
            return [
                'code'     => $code->code,
                'valid_at' => $code->valid_at->format('d/m/Y'),
                'used'     => $code->user_id ? 'oui' : null,
                'user'     => isset($code->user) ? $code->user->name : null,
            ];
        });
    }
}
