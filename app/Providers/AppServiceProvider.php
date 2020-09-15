<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerUserService();
        $this->registerCodeService();
        $this->registerArretService();
        $this->registerThemeService();
        $this->registerMetaService();
        $this->registerAnnonceService();
        $this->registerMailjetService();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Auth
     */
    protected function registerUserService(){

        $this->app->singleton('App\Praticien\User\Repo\UserInterface', function() {
            return new \App\Praticien\User\Repo\UserEloquent( new \App\Praticien\User\Entities\User );
        });
    }

    /**
     * Code
     */
    protected function registerCodeService(){

        $this->app->singleton('App\Praticien\Code\Repo\CodeInterface', function() {
            return new \App\Praticien\Code\Repo\CodeEloquent( new \App\Praticien\Code\Entities\Code );
        });
    }

    /**
     * Arret
     */
    protected function registerArretService(){

        $this->app->singleton('App\Praticien\Arret\Repo\ArretInterface', function() {
            return new \App\Praticien\Arret\Repo\ArretEloquent( new \App\Praticien\Arret\Entities\Arret );
        });
    }

    /**
     * Theme
     */
    protected function registerThemeService(){

        $this->app->singleton('App\Praticien\Theme\Repo\ThemeInterface', function() {
            return new \App\Praticien\Theme\Repo\ThemeEloquent( new \App\Praticien\Theme\Entities\Theme );
        });
    }

    /**
     * registerMetaService
     */
    protected function registerMetaService(){

        $this->app->singleton('App\Praticien\Arret\Repo\MetaInterface', function() {
            return new \App\Praticien\Arret\Repo\MetaEloquent( new \Zoha\Meta\Models\Meta );
        });
    }

    /**
     * registerAnnonceService
     */
    protected function registerAnnonceService(){

        $this->app->singleton('App\Praticien\Newsletter\Repo\AnnonceInterface', function() {
            return new \App\Praticien\Newsletter\Repo\AnnonceEloquent( new \App\Praticien\Newsletter\Entities\Annonce );
        });
    }

    /**
     * Newsletter Content service
     */
    protected function registerMailjetService(){

        $this->app->bind('App\Praticien\Newsletter\Service\MailjetServiceInterface', function()
        {
            if (\App::environment('testing')) {

                $client   = \Mockery::mock('Mailjet\Client');
                $resource = \Mockery::mock('Mailjet\Resources');

                return new \App\Praticien\Newsletter\Service\MailjetService($client,$resource);
            }
            else{
                return new \App\Praticien\Newsletter\Service\MailjetService(
                    new \Mailjet\Client(config('services.mailjet.api'),config('services.mailjet.secret')),
                    new \Mailjet\Resources()
                );
            }
        });
    }
}
