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

    public function getBackend(){

        return $this->arret->with(['themes'])->orderBy('published_at','DESC')->get();
    }

	public function find($id)
    {
		return $this->arret->with(['themes.subthemes'])->find($id);
	}

    public function byCategory($slug,$edition = null)
    {
        return $this->arret->whereHas('themes', function ($query) use ($slug) {
            $query->where('slug', '=', $slug);
        })->edition($edition)
            ->where('published_at','<=',\Carbon\Carbon::today()->startOfDay())
            ->where('status','=','publish')
            ->orderBy('published_at','DESC')->paginate(10);
	}

    public function byYear($year)
    {
        return $this->arret->whereMeta('year',$year)->select('id','published_at','title','status','slug','lang')->get();
    }

    public function create(array $data){

		$arret = $this->arret->create(array_filter([
            'id'           =>  $data['id'] ?? null,
            'published_at' =>  $data['published_at'] ?? null,
            'title'        =>  $data['title'],
            'content'      =>  $data['content'] ?? null,
            'text_content' =>  $data['content'] ? strip_tags($data['content']): null,
            'status'       =>  $data['status'],
            'slug'         =>  $data['slug'],
            'guid'         =>  $data['guid'] ?? null,
            'lang'         =>  $data['lang'] ?? null,
            'created_at'   => date('Y-m-d G:i:s'),
            'updated_at'   => date('Y-m-d G:i:s')
        ]));

		if( ! $arret ) {
			return false;
		}

        if(isset($data['metas']) && !empty($data['metas'])){
            foreach ($data['metas'] as $key => $meta){
                $arret->createMeta($key, $meta);
            }
        }

        if(isset($data['themes']) && !empty($data['themes'])){
            foreach ($data['themes'] as $theme){
                $arret->themes()->attach($theme);
            }
        }

		return $arret;
	}

    public function insert(array $data){

        $arret = $this->arret->create(array_filter([
            'id'           =>  $data['id'] ?? null,
            'published_at' =>  $data['published_at'] ?? null,
            'title'        =>  $data['title'],
            'content'      =>  $data['content'] ?? null,
            'text_content' =>  $data['content'] ? strip_tags($data['content']): null,
            'status'       =>  $data['status'],
            'slug'         =>  $data['slug'],
            'guid'         =>  $data['guid'] ?? null,
            'lang'         =>  $data['lang'] ?? null,
            'created_at'   => date('Y-m-d G:i:s'),
            'updated_at'   => date('Y-m-d G:i:s')
        ]));

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

		if(isset($data['content'])){
            $arret->text_content = strip_tags($data['content']);
        }

		if(isset($data['published_at'])){
            $arret->published_at = $data['published_at'];
        }

        $arret->updated_at = date('Y-m-d G:i:s');
		$arret->save();

        if(isset($data['metas']) && !empty($data['metas'])){
            $arret->deleteMeta();

            foreach ($data['metas'] as $key => $meta){
                $arret->createMeta($key, $meta);
            }
        }

        if(isset($data['themes']) && !empty($data['themes'])){
            $arret->themes()->detach();

            foreach ($data['themes'] as $theme){
                $arret->themes()->attach($theme);
            }
        }

		return $arret;
	}

	public function delete($id)
    {
        $arret = $this->arret->find($id);

		return $arret->delete($id);
	}

    public function searchTerm($term)
    {
        return $this->arret->search($term)->get();
	}

    public function searchLoi($params,$year = null)
    {
        return $this->arret->loi($params)
            ->where('published_at','<=',\Carbon\Carbon::today()->startOfDay())
            ->where('status','=','publish')->edition($year)
            ->orderBy('published_at','DESC')
            ->paginate(10);
    }
}
