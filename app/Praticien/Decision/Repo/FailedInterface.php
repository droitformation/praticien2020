<?php namespace App\Praticien\Decision\Repo;

interface FailedInterface {

    public function getAll();
    public function create(array $data);
    public function update(array $data);
    public function delete($id);
}
