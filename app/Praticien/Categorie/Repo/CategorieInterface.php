<?php namespace App\Praticien\Categorie\Repo;

interface CategorieInterface {

    public function getAll();
	public function find($data);
    public function findParent($id);
	public function create(array $data);
	public function update(array $data);
	public function delete($id);
    public function getTree($rootid);

}
