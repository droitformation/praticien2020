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
       // $this->registerCodeWorkerService();
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
     * CodeWorker

    protected function registerCodeWorkerService(){

        $this->app->singleton('App\Praticien\Code\Worker\CodeWorkerInterface', function() {
            return new \App\Praticien\Code\Worker\CodeWorker(
                \App::make('App\Praticien\Code\Repo\CodeInterface')
            );
        });
    } */
}
