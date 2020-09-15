<?php namespace App\Praticien\Newsletter\Repo;;

interface AnnonceInterface {
    public function getAll();
	public function find($id);
	public function active($date);
	public function create(array $data);
	public function update(array $data);
	public function delete($id);
}
