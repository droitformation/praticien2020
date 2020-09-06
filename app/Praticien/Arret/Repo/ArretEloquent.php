<?php namespace App\Praticien\Arret\Repo;

use App\Praticien\Arret\Repo\ArretInterface;
use App\Praticien\Arret\Entities\Arret as M;

class ArretEloquent implements ArretInterface{

	protected $arret;

	public function __construct(M $arret)
	{
		$this->arret = $arret;
	}

    public function getAll(){

        return $this->arret->get();
    }

    public function getNbr(){

        return $this->arret->with(['themes'])->orderBy('published_at','DESC')->paginate(10);
    }

	public function find($id)
    {
		return $this->arret->find($id);
	}

    public function byCategory($slug,$edition = null)
    {
        return $this->arret->whereHas('themes', function ($query) use ($slug) {
            $query->where('slug', '=', $slug);
        })->edition($edition)->orderBy('created_at','ASC')->paginate(10);
	}

    public function byYear($year)
    {
        return $this->arret->whereMeta('year',$year)->take(100)->get();
    }

    public function create(array $data){

		$arret = $this->arret->create(array(
            'id'           =>  $data['id'],
            'published_at' =>  $data['published_at'] ?? null,
            'title'        =>  $data['title'],
            'content'      =>  $data['content'] ?? null,
            'status'       =>  $data['status'],
            'slug'         =>  $data['slug'],
            'guid'         =>  $data['guid'],
            'lang'         =>  $data['lang'] ?? null,
            'created_at'   => date('Y-m-d G:i:s'),
            'updated_at'   => date('Y-m-d G:i:s')
		));

		if( ! $arret ) {
			return false;
		}

		if(isset($data['metas']) && !empty($data['metas'])){
		    foreach ($data['metas'] as $meta){
                $arret->createMeta($meta['meta_key'], $meta['meta_value']);
            }
        }

        if(isset($data['year']) && !empty($data['year'])){
            foreach ($data['year'] as $year){
                $arret->createMeta('year', $year);
            }
        }

        if(isset($data['themes']) && !empty($data['themes'])){
            foreach ($data['themes'] as $theme){
                $arret->themes()->attach($theme);
            }
        }

		return $arret;
	}

	public function update(array $data)
    {
        $arret = $this->arret->find($data['id']);

		if( ! $arret ){
			return false;
		}

        $arret->fill($data);
        $arret->updated_at = date('Y-m-d G:i:s');
		$arret->save();

		return $arret;
	}

	public function delete($id)
    {
        $arret = $this->arret->find($id);

		return $arret->delete($id);
	}

}
