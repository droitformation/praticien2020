<?php namespace App\Praticien\Arret\Repo;

interface ArretInterface {

    public function getAll();
	public function find($data);
    public function byCategory($slug);
	public function create(array $data);
	public function update(array $data);
	public function delete($id);

}
