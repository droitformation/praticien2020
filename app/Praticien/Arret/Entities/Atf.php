<?php namespace App\Praticien\Arret\Entities;

class Atf
{
    static function url($string){

        // it's an ATF
        $atf = isAtf($string);
        // Grab url
        if($atf){
            return self::getUrl($atf);
        }

        // It's a TF
        $tf = isTf($string);
        // Get Url from database
        if($tf){
            return self::getUrlFromDb($tf);
        }

        return '';
    }

    static function getUrl($atf){

        $client = new \GuzzleHttp\Client(['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
        $goutte = new \Goutte\Client;

        $goutte->setClient($client);

        $url = 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F'.$atf.'%3Afr&lang=fr&zoom=&type=show_document';

        $response = $client->get($url);
        $crawler  = $goutte->request('GET', $url);
        $content  = $crawler->filter('.content .big')->each(function ($node) {
            return $node->text();
        });

        return $response->getStatusCode() == 200 && !empty($content) ? $url : '';
    }

    static function getUrlFromDb($tf){
        $repo  = \App::make('App\Praticien\Decision\Repo\DecisionInterface');
        $found = $repo->findByNumero($tf);

        return $found ? $found->link : '';
    }
}
