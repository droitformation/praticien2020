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


Route::group(['middleware' => ['auth']], function () {
    Route::get('decisions', ['uses' => 'DecisionController@index']);

    Route::get('arrets', ['uses' => 'ArretController@index']);
    Route::get('theme/{id}', ['uses' => 'ArretController@theme']);
    Route::get('subtheme/{id}', ['uses' => 'ArretController@subtheme']);
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

Route::group(['prefix' => 'backend'], function () {

    Route::get('newsletter/{date?}','Praticien\NewsletterController@index');
    Route::match(['get', 'post'], 'letter','Praticien\NewsletterController@letter');
    Route::get('send','Praticien\NewsletterController@send');

    Route::post('date/update','Praticien\DateController@update');
    Route::post('date/delete','Praticien\DateController@delete');

    Route::post('search','Praticien\SearchController@search');

    Route::get('/','Praticien\ArchiveController@index');
    Route::get('/archive','Praticien\ArchiveController@archive');
    Route::get('archives/{year}/{date}/{id?}','Praticien\ArchiveController@archives');

    Route::post('transfert','Praticien\ArchiveController@transfert');
    Route::match(['get', 'post'], 'testing','Praticien\ArchiveController@testing');
    Route::match(['get', 'post'], 'abos','Praticien\UserController@index');

    Route::get('decisions/{date}/{id?}','Praticien\DecisionController@index');
    Route::post('decision/update','Praticien\DecisionController@update');
});

Route::group(['prefix' => 'api'], function () {
    Route::post('/search','Api\MainController@search');
    Route::get('/categories','Api\MainController@categories');
    Route::get('/categorie/{id}','Api\MainController@categorie');
    Route::get('/decisions','Api\MainController@decisions');
    Route::get('/decision/{id}/{year}','Api\MainController@decision');

    Route::post('/user','Api\UserController@show');
    Route::post('/abo/make','Api\AboController@make');
    Route::post('/abo/remove','Api\AboController@remove');
    Route::post('/abo/cadence','Api\AboController@cadence');
});

Route::get('alert', function () {

    $repo  = \App::make('App\Praticien\User\Repo\UserInterface');
    $alert = \App::make('App\Praticien\Bger\Worker\AlertInterface');
    $user  = $repo->find(2744);

    $repo = App::make('App\Praticien\Decision\Repo\DecisionInterface');
    $decisions = $repo->search(['terms' => null, 'categorie' => 226, 'published' => 1, 'publication_at' => '2019-05-10']);

    $alert->setCadence('daily')->setDate(weekRange('2019-05-16')->toArray());
    $abos = $alert->getUserAbos($user);

    return new \App\Mail\AlerteDecision($user, weekRange('2019-05-16')->toArray(), $abos);
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

Route::get('test', function() {

/*    $metas = \App\Praticien\Wordpress\Entities\UserMeta::get();

    echo '<pre>';
    print_r($metas->pluck('meta_key')->unique());
    echo '</pre>';
    exit;*/

    $users = \App\Praticien\Wordpress\Entities\User::all();
    foreach ($users as $user){
        $converted = \App\Praticien\Wordpress\Convert\User::convert($user);
        echo '<pre>';
        print_r($converted);
        echo '</pre>';
    }

    exit;

    $user = \App\Praticien\Wordpress\Entities\User::find(15);

    $results = $user->abos->mapToGroups(function ($abo, $key) use ($user) {
        return [
            $abo->refCategorie => array_filter([
                'keywords' => $abo->keywords,
                'isPub'    => $user->published->contains('refCategorie', $abo->refCategorie)
            ])
        ];
    })->map(function ($keywords, $categorie_id) {
        return $keywords->reject(function ($keyword) {
            return empty(array_filter($keyword));
        })->toArray();
    })->toArray();

    echo '<pre>';
    print_r($results);
    print_r($user->abos->toArray());
    print_r($user->published->toArray());
    echo '</pre>';
    exit;

    /*


    /*    $abo = \App\Praticien\Abo\Entities\Abo::create([
            'user_id'      => 1,
            'categorie_id' => 1,
            'keywords'     => 'words',
        ]);*/


    $abo = factory(\App\Praticien\Abo\Entities\Abo::class)->create([
        'user_id'      => 1,
        'categorie_id' => 1,
        'keywords'     => 'words',
    ]);

    echo '<pre>';
    print_r($abo);
    echo '</pre>';
    exit;
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

/*    $wordpress = \App::make('App\Praticien\Wordpress\Repo\PostRepo');
    $results = $wordpress->getAll();

    foreach ($results as $result){
        $arret = \App\Praticien\Wordpress\Convert\Arret::convert($result);

        $repo = \App::make('App\Praticien\Arret\Repo\ArretInterface');
        $repo->create($arret);
    }*/

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
