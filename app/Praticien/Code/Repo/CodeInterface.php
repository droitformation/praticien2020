<?php namespace App\Praticien\Code\Repo;

interface CodeInterface {

    public function getAll($year=null);
    public function years();
	public function find($data);
	public function valid($code);
    public function active($user_id);
    public function make($nbr,$data);
	public function create(array $data);
	public function update(array $data);
    public function updateCode($code,$user_id);
	public function delete($id);

}
