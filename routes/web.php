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

Route::get('arrets', ['uses' => 'ArretController@index']);
Route::get('categorie/{id}', ['uses' => 'ArretController@categorie']);
Route::get('subcategorie/{id}', ['uses' => 'ArretController@subcategorie']);

Route::post('sendMessage', ['uses' => 'FrontendController@sendMessage']);

Route::get('message', function() {
    return new \App\Mail\ContactMessage([
        'nom'      => 'Cindy Leschaud',
        'email'    => 'cindy.leschaud@gmail.com',
        'remarque' => '<p>Un message lorem ipsum dolor amet.</p>'
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('test', function() {
    //$wordpress = new \App\Praticien\Wordpress\Category();
  //  $results = $wordpress->getCategories();
    /* $categories = \App\Praticien\Wordpress\Entites\Taxonomy::where('taxonomy', 'category')
         //->where('parent','=',0)
         ->where('count','>',0)
         ->get();

     $results = $categories->map(function ($categorie, $key) {
         $convert = \App\Praticien\Wordpress\Convert\Categorie::convert($categorie);

         $repo = \App::make('App\Praticien\Categorie\Repo\CategorieInterface');
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
        $convert = \App\Praticien\Wordpress\Convert\Categorie::convert($categorie);

        $repo = \App::make('App\Praticien\Categorie\Repo\CategorieInterface');
        $repo->create($convert);
    });



    $repo = \App::make('App\Praticien\Categorie\Repo\CategorieInterface');
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
        $convert = \App\Praticien\Wordpress\Convert\Categorie::convert($categorie);

        $repo = \App::make('App\Praticien\Categorie\Repo\CategorieInterface');
        $repo->create($convert);
    });*/

/*    $wordpress = \App::make('App\Praticien\Wordpress\Repo\PostRepo');
    $results = $wordpress->getAll();

    foreach ($results as $result){
        $arret = \App\Praticien\Wordpress\Convert\Arret::convert($result);

        $repo = \App::make('App\Praticien\Arret\Repo\ArretInterface');
        $repo->create($arret);
    }*/

    $repo = \App::make('App\Praticien\Categorie\Repo\CategorieInterface');
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
