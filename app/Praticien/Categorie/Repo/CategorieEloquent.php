<?php namespace App\Praticien\Categorie\Repo;

use App\Praticien\Categorie\Repo\CategorieInterface;
use App\Praticien\Categorie\Entities\categorie as M;

class CategorieEloquent implements CategorieInterface{

	protected $categorie;

	public function __construct(M $categorie)
	{
		$this->categorie = $categorie;
	}

    public function getAll(){

        return $this->categorie->get();
    }

	public function find($id)
    {
		return $this->categorie->with(['arrets','subcategory'])->find($id);
	}

    public function findParent($id)
    {
        return $this->categorie->where('parent_id','=',$id)->get();
    }

    public function bySlug($slug)
    {
        return $this->categorie->where('slug','=',$slug)->first();
    }

	public function create(array $data){

		$categorie = $this->categorie->create(array(
            'id'           => $data['id'],
            'name'         => $data['name'],
            'slug'         => $data['slug'],
            'parent_id'    => isset($data['parent_id']) && $data['parent_id'] > 0 ? $data['parent_id'] : 0,
            'created_at'   => date('Y-m-d G:i:s'),
            'updated_at'   => date('Y-m-d G:i:s')
		));

		if( ! $categorie ) {
			return false;
		}

		return $categorie;
	}

	public function update(array $data)
    {
        $categorie = $this->categorie->find($data['id']);

		if( ! $categorie ){
			return false;
		}

        $categorie->fill($data);
        $categorie->updated_at = date('Y-m-d G:i:s');
		$categorie->save();

		return $categorie;
	}

	public function delete($id)
    {
        $categorie = $this->categorie->find($id);

		return $categorie->delete($id);
	}

    public function getTree($rootid)
    {
        $arr = [];

        $result = $this->findParent($rootid);

        foreach ($result as $row) {
            $arr[] = array(
                "id"       => $row->id,
                "name"     => $row->name,
                "children" => $this->getTree($row->id)
            );
        }

        return $arr;
    }
}
