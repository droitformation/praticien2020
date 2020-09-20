<?php namespace App\Praticien\User\Repo;

interface UserInterface {

    public function getAll();
    public function getActiveWithAbos($cadence = null);
    public function getAlerts($params);
    public function getActives();
    public function getInactives();
    public function find($data);
    public function findByEmail($email);
    public function getByCadence($cadence, $exclude = []);
    public function convert(array $data);
    public function create(array $data);
    public function update(array $data);
    public function delete($id);

}
