<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['uses' => 'FrontendController@index']);
Route::get('about', ['uses' => 'FrontendController@about']);
Route::get('access', ['uses' => 'FrontendController@access']);
Route::get('contact', ['uses' => 'FrontendController@contact']);
Route::post('sendMessage', ['uses' => 'FrontendController@sendMessage']);

Route::match(['get', 'post'],'decisions', ['uses' => 'DecisionController@index']);
Route::get('decision/{id}/{year}', ['uses' => 'DecisionController@show']);
Route::match(['get', 'post'],'categorie/{id}', ['uses' => 'DecisionController@categorie']);
Route::get('export/{id}', ['uses' => 'DecisionController@export']);

Route::get('newsletter/unsubscribe', ['uses' => 'NewsletterController@unsubscribe']);
Route::get('newsletter/preview/{date?}', ['uses' => 'NewsletterController@preview']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('arrets', ['uses' => 'ArretController@index']);
    Route::get('theme/{id}/{year?}', ['uses' => 'ArretController@theme']);
    Route::get('subtheme/{id}/{year?}', ['uses' => 'ArretController@subtheme']);
});

Route::get('message', function() {
    return new \App\Mail\ContactMessage([
        'nom'      => 'Cindy Leschaud',
        'email'    => 'cindy.leschaud@gmail.com',
        'remarque' => '<p>Un message lorem ipsum dolor amet.</p>'
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/abos', 'HomeController@abos')->name('abos');
Route::post('/cadence', 'HomeController@cadence')->name('cadence');
Route::post('/update', 'HomeController@update')->name('update');

Route::post('abo/subscribe', 'SubscribeController@subscribe')->name('subscribe');
Route::post('abo/unsubscribe', 'SubscribeController@unsubscribe')->name('unsubscribe');

Route::post('newsletter/subscribe', 'NewsletterController@subscribe');
Route::post('newsletter/unsubscribe', 'NewsletterController@unsubscribe');

Route::get('/expired', 'CodeController@expired')->name('expired');
Route::post('/activate', 'CodeController@activate')->name('activate');

Route::group(['prefix' => 'backend' ,'middleware' => ['auth','admin']], function () {

    Route::get('arret/year/{year}','Backend\ArretController@year');
    Route::post('arret/atf','Backend\ArretController@atf');
    Route::resource('arret', 'Backend\ArretController');

    Route::resource('theme', 'Backend\ThemeController');

    Route::post('uploadRedactor', 'Backend\UploadController@uploadRedactor');
    Route::get('imageJson/{id?}', ['uses' => 'Backend\UploadController@imageJson']);
    Route::get('fileJson/{id?}',  ['uses' => 'Backend\UploadController@fileJson']);

    /*
     * Administrator
     * */
    Route::get('/','Backend\BackendController@index');
    Route::get('decision','Backend\DecisionController@index');

    Route::get('decision/{id}/{year}','Backend\DecisionController@show');
    Route::get('decisions/{date}/{year}','Backend\DecisionController@decisions');
    Route::get('archive/{year?}','Backend\DecisionController@archive');
    Route::post('decision/search','Backend\DecisionController@search');

    Route::get('user','Backend\UserController@index');
    Route::get('user/{id}','Backend\UserController@show');
    Route::match(['get', 'post'], 'users/alerte','Backend\UserController@alerte');
    Route::get('users/inactive','Backend\UserController@inactive');
    Route::post('users/code','Backend\UserController@code');
    Route::put('user/{id}','Backend\UserController@update');

    Route::get('newsletter/{date?}','Backend\NewsletterController@index');

    Route::get('archives/{year}/{date}/{id?}','Praticien\ArchiveController@archives');

   // Route::get('newsletter/{date?}','Praticien\NewsletterController@index');
    Route::match(['get', 'post'], 'letter','Praticien\NewsletterController@letter');
    Route::get('send','Praticien\NewsletterController@send');

    Route::post('date/update','Praticien\DateController@update');
    Route::post('date/delete','Praticien\DateController@delete');

    Route::post('search','Praticien\SearchController@search');

    Route::post('transfert','Praticien\ArchiveController@transfert');
    Route::match(['get', 'post'], 'testing','Praticien\ArchiveController@testing');

    //Route::match(['get', 'post'], 'abos','Praticien\UserController@index');

    //Route::get('decisions/{date}/{id?}','Praticien\DecisionController@index');
    //Route::post('decision/update','Praticien\DecisionController@update');
});

Route::group(['prefix' => 'api'], function () {

    Route::post('/decisions','Api\DecisionController@index');

/*    Route::post('/search','Api\MainController@search');
    Route::get('/categories','Api\MainController@categories');
    Route::get('/categorie/{id}','Api\MainController@categorie');
    Route::get('/decision/{id}/{year}','Api\MainController@decision');

    Route::post('/user','Api\UserController@show');
    Route::post('/abo/make','Api\AboController@make');
    Route::post('/abo/remove','Api\AboController@remove');
    Route::post('/abo/cadence','Api\AboController@cadence');*/
});

Route::get('alert', function () {

    $repo  = \App::make('App\Praticien\User\Repo\UserInterface');
    $alert = \App::make('App\Praticien\Bger\Worker\AlertInterface');
    $user  = $repo->find(15);

    $repo      = App::make('App\Praticien\Decision\Repo\DecisionInterface');
    $decisions = $repo->search(['terms' => null, 'categorie' => 226, 'published' => 1, 'publication_at' => '2019-05-10']);

    $alert->setCadence('daily')->setDate(weekRange('2020-09-08')->toArray());
    $abos = $alert->getUserAbos($user);

    return new \App\Mail\AlerteDecision($user, weekRange('2020-09-08')->toArray(), $abos);
});

Route::get('handlealert', function () {

    $alert = new \App\Jobs\SendEmailAlert(weekRange('2019-05-10')->toArray(), 'weekly');
    $abos  = $alert->handle();

    foreach ($abos as $abo){
        echo (new \App\Mail\AlerteDecision($abo['user'], weekRange('2019-05-10')->toArray(), $abo['abos']))->render();
    }
    return view('test');
});

/*
 * Transfert
 * */


Route::get('posts','TransfertController@posts');
Route::get('themes','TransfertController@themes');
Route::get('users','TransfertController@users');
Route::get('codes','TransfertController@codes');

Route::get('test', function() {

    $user = \App\Praticien\User\Entities\User::find(4);


    $alert = new \App\Praticien\User\Entities\Alert($user,'daily','2020-09-14');

    echo '<pre>';
    print_r($alert->status());
    echo '</pre>';
    exit;

    $worker = \App::make('App\Praticien\Newsletter\Worker\NewsletterWorker');
    $url    = 'newsletter/preview';
    $date   = '2020-09-04';

    $url = $date ? $url.'/'.$date : $url;

    $worker->setUrl($url)->send_test();

    exit;

    $codes = \App\Praticien\Wordpress\Entities\Code::get();

    echo '<pre>';
    print_r($codes);
    echo '</pre>';
    exit;

    $repo = App::make('App\Praticien\Decision\Repo\DecisionInterface');

    $decisions = $repo->search(['terms' => ['Haldy','Bohnet'], 'categorie' => 247, 'published' => null, 'publication_at' => '2020-09-07']);

    echo '<pre>';
    print_r($decisions);
    echo '</pre>';
    exit;
  /*  $text   = '';
    $result = strip_word_html($text);

    echo '<pre>';
    print_r($result);
    echo '</pre>';
    exit;*/

    $atf = 'ATF 143 III 113';
    $url = 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F'.$atf.'%3Afr&lang=fr&zoom=&type=show_document';

    return \App\Praticien\Arret\Entities\Atf::url($atf);

    $atf    = str_replace('ATF ','',$atf);
    $atf    = str_replace(' ','-',$atf);

    $client = new \GuzzleHttp\Client(['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
    $goutte = new \Goutte\Client;

    $goutte->setClient($client);

    $url = 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2F'.$atf.'%3Afr&lang=fr&zoom=&type=show_document';
    $fail = 'http://relevancy.bger.ch/php/clir/http/index.php?highlight_docid=atf%3A%2F%2FATF%20134-III-1%3Afr&lang=fr&zoom=&type=show_document';

    $response = $client->get($url);
    $crawler  = $goutte->request('GET', $fail);

    $content = $crawler->filter('.content .big')->each(function ($node) {
        return $node->text();
    });

    echo '<pre>';
    print_r($content);
    print_r($response->getBody());
    echo '</pre>';
    exit;

    exit;
/*    $metas = \App\Praticien\Wordpress\Entities\UserMeta::get();

    echo '<pre>';
    print_r($metas->pluck('meta_key')->unique());
    echo '</pre>';
    exit;*/

/*

    $user = \App\Praticien\Wordpress\Entities\User::find(15);
    $converted = \App\Praticien\Wordpress\Convert\User::convert($user);

    echo '<pre>';
    print_r($converted);
    echo '</pre>';
    exit;

    $users = \App\Praticien\Wordpress\Entities\User::all();

    $roles = [];

    foreach ($users as $user){
        $converted = \App\Praticien\Wordpress\Convert\User::convert($user);
        echo '<pre>';
        print_r($converted);
        echo '</pre>';
        exit;
        $roles[] = array_keys($converted['roles']);
    }

    echo '<pre>';
    print_r(array_unique(array_flatten($roles)));
    echo '</pre>';
    exit;

    exit;*/
    /*
    $user = \App\Praticien\Wordpress\Entities\User::find(15);

    $results = $user->abos->map(function ($abo, $key) {
            return $abo->refCategorie;
        })->unique()->map(function ($categorie, $key) use ($user) {
            $words = $user->abos->where('refCategorie', $categorie);

            return [
                'categorie_id' => $categorie,
                'keywords'     => $words->pluck('keywords')->unique()->toArray(),
                'isPub'        => !$user->published->where('refCategorie', $categorie)->pluck('ispub')->unique()->isEmpty()
            ];
        })->toArray();

    echo '<pre>';
    print_r($results);
    print_r($user->abos->toArray());
    print_r($user->published->toArray());
    echo '</pre>';
    exit;

    /*    $abo = \App\Praticien\Abo\Entities\Abo::create([
            'user_id'      => 1,
            'categorie_id' => 1,
            'keywords'     => 'words',
        ]);


    $abo = factory(\App\Praticien\Abo\Entities\Abo::class)->create([
        'user_id'      => 1,
        'categorie_id' => 1,
        'keywords'     => 'words',
    ]);

    echo '<pre>';
    print_r($abo);
    echo '</pre>';
    exit;*/
    //
    // $wordpress = new \App\Praticien\Wordpress\Category();
  //  $results = $wordpress->getCategories();
    /* $categories = \App\Praticien\Wordpress\Entites\Taxonomy::where('taxonomy', 'category')
         //->where('parent','=',0)
         ->where('count','>',0)
         ->get();

     $results = $categories->map(function ($categorie, $key) {
         $convert = \App\Praticien\Wordpress\Convert\Theme::convert($categorie);

         $repo = \App::make('App\Praticien\Theme\Repo\ThemeInterface');
         $repo->create($convert);
     });
     exit;
       */

     /*
    $results = collect($results)->mapToGroups(function ($categorie, $key) {
        $id = $categorie->parent > 0 ? $categorie->parent : $categorie->term_id;
        return [$id => $categorie];
    });

    $results = $wordpress->getTree(0);

    $categories = \App\Praticien\Wordpress\Entites\Taxonomy::where('taxonomy', 'category')
        //->where('parent','=',0)
        ->where('count','>',0)
        ->get();

    $results = $categories->map(function ($categorie, $key) {
        $convert = \App\Praticien\Wordpress\Convert\Theme::convert($categorie);

        $repo = \App::make('App\Praticien\Theme\Repo\ThemeInterface');
        $repo->create($convert);
    });

    $repo = \App::make('App\Praticien\Theme\Repo\ThemeInterface');
    $results = $repo->getTree(0);

    echo '<pre>';
    print_r($results);
    echo '</pre>';
    exit;
    */


/*    $categories = \App\Praticien\Wordpress\Entites\Taxonomy::where('taxonomy', 'category')
        //->where('parent','=',0)
        ->where('count','>',0)
        ->get();

    $results = $categories->map(function ($categorie, $key) {
        $convert = \App\Praticien\Wordpress\Convert\Theme::convert($categorie);

        $repo = \App::make('App\Praticien\Theme\Repo\ThemeInterface');
        $repo->create($convert);
    });*/

/**/
    $wordpress = \App::make('App\Praticien\Wordpress\Repo\PostRepo');
    $results = $wordpress->getAll();

    foreach ($results as $result){
        $arret = \App\Praticien\Wordpress\Convert\Arret::convert($result);

        echo '<pre>';
        print_r($arret);
        echo '</pre>';
        exit;

        $repo = \App::make('App\Praticien\Arret\Repo\ArretInterface');
        $repo->create($arret);
    }

    $repo = \App::make('App\Praticien\Theme\Repo\ThemeInterface');
    $cat = $repo->find(71);

    echo '<pre>';
    print_r($cat->parent);
    echo '</pre>';
    exit;

exit;
    $txt = $results->first();

    \File::put(base_path('tests/datadump/post.json'),json_encode($txt->toArray()));

    $arret = \App\Praticien\Wordpress\Convert\Arret::convert($results->first());

    $repo = \App::make('App\Praticien\Arret\Repo\ArretInterface');
    $repo->create($arret);
    exit;

    $results = $results->map(function ($arret) {

        return App\Praticien\Wordpress\Convert\Arret::convert($arret);

        $categories = $arret->taxonomies->where('taxonomy','category')->map(function ($categorie) {
            return $categorie->term;
        });

        echo '<pre>';
        print_r($categories);
        echo '</pre>';

    });


 /*   $results = $results->map(function ($arret) {
        return App\Praticien\Wordpress\Convert\Arret::convert($arret);
    });
 */

    echo '<pre>';
    print_r($results);
    echo '</pre>';
    exit;

});

Route::get('test_convert', function() {


    // set location of docx text content file
    $xmlFile = public_path('Droitfiscalinternational.docx');

    $phpWord = \PhpOffice\PhpWord\IOFactory::load($xmlFile);
    $htmlWriter = new \PhpOffice\PhpWord\Writer\HTML($phpWord);
    $htmlWriter->save(public_path('test.html'));
    exit;
});
