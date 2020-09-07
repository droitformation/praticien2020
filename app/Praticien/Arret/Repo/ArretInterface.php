<?php namespace App\Praticien\Arret\Repo;

interface ArretInterface {

    public function getAll();
    public function getNbr();
	public function find($data);
    public function byCategory($slug,$edition = null);
    public function byYear($year);
	public function create(array $data);
    public function insert(array $data);
	public function update(array $data);
	public function delete($id);

}
