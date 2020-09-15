<?php namespace App\Praticien\Newsletter\Repo;

use App\Praticien\Newsletter\Repo\AnnonceInterface;
use App\Praticien\Newsletter\Entities\Annonce as M;

class AnnonceEloquent implements AnnonceInterface{

	protected $annonce;

	public function __construct(M $annonce)
	{
		$this->annonce = $annonce;
	}

    public function getAll(){

        return $this->annonce->get();
    }

	public function find($id)
    {
		return $this->annonce->find($id);
	}

    public function active($date)
    {
	    return $this->annonce->where('start_at','<=',$date->toDateString())->where('end_at','>=',$date->toDateString())->first();
    }

	public function create(array $data){

		$annonce = $this->annonce->create(array(
			'title'       => $data['title'],
            'link'        => $data['link'] ?? null,
            'content'     => $data['content'] ?? null,
            'start_at'    => $data['start_at'],
            'end_at'      => $data['end_at'],
            'created_at'  => date('Y-m-d G:i:s'),
            'updated_at'  => $data['updated_at'] ?? date('Y-m-d G:i:s')
		));

		if( ! $annonce ) {
			return false;
		}

		return $annonce;
	}

	public function update(array $data)
    {
        $annonce = $this->annonce->find($data['id']);

		if( ! $annonce ) {
			return false;
		}

        $annonce->fill($data);
        $annonce->updated_at = date('Y-m-d G:i:s');
		$annonce->save();

		return $annonce;
	}

	public function delete($id)
    {
        $annonce = $this->annonce->find($id);

		return $annonce->delete($id);
	}

}
