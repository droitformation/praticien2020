<?php namespace App\Praticien\Api;

trait FetchData
{
    public function getData($url, $params = null){

        $action = $params ? 'post' : 'get';

        try {
            $response = $this->client->$action($this->base_url.'/'.$url, ['query' => $params]);
            $data     = json_decode($response->getBody(), true);

            return $data;
        }
        catch (GuzzleException $error) {}

        return collect([]);
    }
}
