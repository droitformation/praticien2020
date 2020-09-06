<?php namespace App\Praticien\Theme\Repo;

interface ThemeInterface {

    public function getAll();
    public function getParents();
	public function find($data);
    public function findParent($id);
	public function create(array $data);
	public function update(array $data);
	public function delete($id);
    public function getTree($rootid);

}
