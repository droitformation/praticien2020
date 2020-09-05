<?php namespace App\Praticien\Bger\Utility;

use Goutte\Client;

/*
* Class to prepare Lists
 * Main and Date Lists
*/

class Liste
{
    public $html;
    public $listData = [];
    public $listArret = [];
    public $date;

    protected $clean;
    protected $keys;
    protected $mainListUrl;
    protected $dateListUrl = null;

    public function __construct()
    {
        $this->clean = new \App\Praticien\Bger\Utility\Clean();
        $this->html  = new Client();

        //  Hackery to allow HTTPS
        $guzzleclient = new \GuzzleHttp\Client(['timeout' => 60, 'verify' => false,]);
        $this->html->setClient($guzzleclient);

        $this->mainListUrl = 'http://relevancy.bger.ch/php/aza/http/index_aza.php?lang=fr&mode=index';
        $this->keys        = collect(['numero','categorie','subcategorie','publication_at','decision_at']);
    }

    /* ========================================
       GRAB LIST FROM TF WEBSITE
    ==========================================*/
    public function getList($format = false)
    {
        $crawler = $this->html->request('GET', $this->mainListUrl);

        $content = $crawler->filter('a')->each(function ($node) {
            $date = extractParams($node->attr('href'));
            return ($date && dateIsValid($date,'Ymd')) ? $date : false;
        });

        return collect($content)->reject(function ($name) {
            return empty($name);
        })->format($format);
    }

    /* ========================================
      Date format Ydm
    ==========================================*/
    public function setUrl($date)
    {
        $this->date = \Carbon\Carbon::parse($date)->format('Ymd');
        $this->dateListUrl = 'http://relevancy.bger.ch/php/aza/http/index_aza.php?date='.$this->date.'&lang=fr&mode=news';

        return $this;
    }

    /* ========================================
      Get list decision for given Date format Ydm
     ==========================================*/
    public function getListDecisions()
    {
        if(!$this->dateListUrl){
            $this->exception('No date for dateListUrl provided');
        }

        $this->grabHtmlArrayList()->prepareDataFromList();

        return $this->listArret;
    }

    public function prepareDataFromList()
    {
        if(empty($this->listData)){
            $this->listArret = collect([]);
        }

        $this->listArret = collect($this->listData)
            ->chunk(2)->map(function($items){
                return $items->collapse()->filter()->values()->map(function ($item, $key) {
                    return $this->clean->removeWhitespace($item);
                });
            })->map(function ($values) {

                // get only 4 values, be sure to have 4 items  in case there is no subcategorie
                $values = $values->splice(0,4);
                if($values->count() != 4) $values->push('-');

                // Validate and format dates
                $publication_at = $this->validConvertDateString($this->date,'Ymd');
                $decision_at    = $this->validConvertDateString($values->shift(),'d.m.Y'); // first item is the decision date

                // add decision date end of the array/collection
                $values->push($publication_at);
                $values->push($decision_at);

                // Combine keys 'numero','categorie','subcategorie','publication_at','decision_at'
                return $this->keys->combine($values)->toArray();

            })->reject(function($arret){
                // Reject if dates are not valid dates
                $result = !dateIsValid($arret['publication_at'],'Y-m-d') || !dateIsValid($arret['decision_at'],'Y-m-d');
                if($result){ \Log::info('Arret fetched with invalid date '.$arret['numero']);  }

                return $result;
            });

        return $this;
    }

    public function grabHtmlArrayList()
    {
        // Get html from page
        $crawler = $this->html->request('GET', $this->dateListUrl);

        // Parse table get each td inner text
        $content = $crawler->filter('TABLE')->each(function ($node) {
            return $node->filter('TR')->each(function ($node) {
                return $node->filter('TD')->each(function ($child) {
                    return $child->text();
                });
            });
        });

        // Get only second array and remove empty values
        if(!isset($content[1]) && empty($content[1])){
            return $this;
        }

        $liste = array_filter($content[1]);

        // Make sure the number of arrays are even
        $this->listData = ((count($liste) % 2) == 0) ? $liste : $this->exception('Un even number of array from date tables: Fetch.php, line 152. Date: '.$this->dateListUrl);

        return $this;
    }

    /* ========================================
      Small helpers
     ==========================================*/
    protected function exception($message){
        throw new \App\Exceptions\ProblemFetchException($message);
    }

    public function validConvertDateString($date,$format)
    {
        return dateIsValid($date,$format) ? \Carbon\Carbon::parse($date)->format('Y-m-d') : null;
    }

    public function isAtfUrl($atf)
    {
        $regex_atf = '(ATF)\s\d{1,3}\s\w{1,4}\s\d{1,3}';
        $regex_tf  = '(TF)\s\d\w(_)\d{1,4}\/{1,4}\d{4}';

        $atf  = str_replace('ATF ','',$atf);
        $atf  = str_replace(' ','-',$atf);

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
}
