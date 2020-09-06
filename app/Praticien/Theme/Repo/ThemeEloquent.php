<?php namespace App\Praticien\Theme\Repo;

use App\Praticien\Theme\Repo\ThemeInterface;
use App\Praticien\Theme\Entities\Theme as M;

class ThemeEloquent implements ThemeInterface{

	protected $theme;

	public function __construct(M $theme)
	{
		$this->theme = $theme;
	}

    public function getAll(){

        return $this->theme->get();
    }

    public function getParents()
    {
        return $this->theme->with(['subthemes'])->where('parent_id','=',0)->get();
    }

	public function find($id)
    {
		return $this->theme->with(['arrets','subthemes'])->find($id);
	}

    public function findParent($id)
    {
        return $this->theme->where('parent_id','=',$id)->get();
    }

    public function bySlug($slug)
    {
        return $this->theme->where('slug','=',$slug)->first();
    }

	public function create(array $data){

		$theme = $this->theme->create(array_filter([
            'id'           => $data['id'] ?? null,
            'name'         => $data['name'],
            'slug'         => isset($data['slug']) ? $data['slug'] : str_slug($data['name']),
            'parent_id'    => isset($data['parent_id']) && $data['parent_id'] > 0 ? $data['parent_id'] : 0,
            'created_at'   => date('Y-m-d G:i:s'),
            'updated_at'   => date('Y-m-d G:i:s')
        ]));

		if( ! $theme ) {
			return false;
		}

		return $theme;
	}

	public function update(array $data)
    {
        $theme = $this->theme->find($data['id']);

		if( ! $theme ){
			return false;
		}

        $theme->fill($data);
        $theme->updated_at = date('Y-m-d G:i:s');
		$theme->save();

		return $theme;
	}

	public function delete($id)
    {
        $theme = $this->theme->find($id);

		return $theme->delete($id);
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
