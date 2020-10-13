<?php namespace tests\factories;

use App\Praticien\User\Entities\User as User;
use App\Praticien\Decision\Entities\Decision as Decision;
use App\Praticien\Abo\Entities\Abo as Abo;

use App\Praticien\Code\Entities\Code as Code;
use App\Praticien\Categorie\Entities\Categorie as Categorie;
use App\Praticien\Abo\Entities\Abo_keyword as Abo_keyword;
use App\Praticien\Arret\Entities\Arret as Arret;
use App\Praticien\Theme\Entities\Theme as Theme;
use App\Praticien\Categorie\Entities\Categorie_keyword as Categorie_keyword;

class ObjectFactory
{
    protected $faker;
    protected $categories;

    public function __construct()
    {
        $categorie = \App::make('App\Praticien\Categorie\Repo\CategorieInterface');

        $this->categories = $categorie->getAll()->pluck('name','id');
        $this->faker      = \Faker\Factory::create();
    }

    public function makeUser($data = [])
    {
        $first_name = isset($data['first_name']) ? $data['first_name'] : $this->faker->firstName;
        $last_name  = isset($data['last_name']) ? $data['last_name'] : $this->faker->lastName;
        $email      = isset($data['email']) ? $data['email'] : $this->faker->email;
        $cadence    = isset($data['cadence']) ? $data['cadence'] : 'daily';

        return User::factory()->create([
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'email'        => $email,
            'cadence'      => $cadence,
            'active_until' => \Carbon\Carbon::tomorrow()->startOfDay()->toDateTimeString()
        ]);
    }

    public function makeAbo($user = null, $categorie = null, $keywords = null)
    {
        if(!$user){
            $user = $this->makeUser();
        }

        if(!$categorie){
            $categorie = $this->categories->random();
            $categorie = $categorie->id;
        }

        return Abo::factory()->create([
            'user_id'       => $user->id,
            'categorie_id'  => $categorie,
            'keywords'      => $keywords,
        ]);
    }

    public function multipleAbos($user, $data)
    {
        foreach($data as $new){
            $abos[] = $this->makeAbo($user, $new['categorie'], $new['keywords']);
        }

        return $abos ?? [];
    }

    public function makeDecisions($publication_at, $data)
    {
        return collect($data)->map(function ($new) use ($publication_at) {
            return Decision::factory()->create([
                'publication_at' => $publication_at,
                'decision_at'    => $this->faker->dateTime,
                'categorie_id'   => $new['categorie_id'],
                'texte'          => $new['texte'],
                'remarque'       => $this->faker->word,
                'numero'         => $this->faker->numberBetween(11,34).'A_/2017',
                'link'           => $this->faker->url,
            ]);
        });
    }
}
