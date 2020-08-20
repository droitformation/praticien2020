<?php namespace App\Praticien\Api;

use App\Praticien\Api\FetchData;

class UserApi
{
    use FetchData;

    protected $client;
    protected $base_url;

    public function __construct($client = null)
    {
        $this->client   = $client ? $client : new \GuzzleHttp\Client(['verify' => false, 'http_errors' => false]); //,'debug' => true
        $this->base_url = (\App::environment() == 'local' ? 'https://apitf.test/api' : 'http://hub.droitpraticien.ch/api');
    }

    public function getUser($id)
    {
        return $this->getData('user', ['id' => $id]);
    }
}
