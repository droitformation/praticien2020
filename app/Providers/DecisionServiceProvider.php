<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DecisionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDecisionService();
        $this->registerFailedService();
        $this->registerCategorieService();
        $this->registerCategorieKeywordService();
        $this->registerCategorieWorkerService();
        $this->registerAboService();
        $this->registerUserService();
        $this->registerDecisionWorkerService();
        $this->registerAlertWorkerService();
        $this->registerAboWorkerService();
        $this->registerUserWorkerService();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Decision
     */
    protected function registerDecisionService(){

        $this->app->singleton('App\Praticien\Decision\Repo\DecisionInterface', function()
        {
            return new \App\Praticien\Decision\Repo\DecisionEloquent( new \App\Praticien\Decision\Entities\Decision );
        });
    }

    /**
     * Failed
     */
    protected function registerFailedService(){

        $this->app->singleton('App\Praticien\Decision\Repo\FailedInterface', function()
        {
            return new \App\Praticien\Decision\Repo\FailedEloquent( new \App\Praticien\Decision\Entities\Failed );
        });
    }

    /**
     * Abo
     */
    protected function registerAboService(){

        $this->app->singleton('App\Praticien\Abo\Repo\AboInterface', function()
        {
            return new \App\Praticien\Abo\Repo\AboEloquent(
                new \App\Praticien\Abo\Entities\Abo(),
                new \App\Praticien\Abo\Entities\Abo_keyword()
            );
        });
    }

    /**
     * Abo
     */
    protected function registerUserService(){

        $this->app->singleton('App\Praticien\User\Repo\UserInterface', function()
        {
            return new \App\Praticien\User\Repo\UserEloquent( new \App\Praticien\User\Entities\User );
        });
    }

    /**
     * Categorie
     */
    protected function registerCategorieService(){

        $this->app->singleton('App\Praticien\Categorie\Repo\CategorieInterface', function()
        {
            return new \App\Praticien\Categorie\Repo\CategorieEloquent(
                new \App\Praticien\Categorie\Entities\Categorie(),
                new \App\Praticien\Categorie\Entities\Parent_categorie()
            );
        });
    }

    /**
     * CategorieKeyword
     */
    protected function registerCategorieKeywordService(){

        $this->app->singleton('App\Praticien\Categorie\Repo\CategorieKeywordInterface', function()
        {
            return new \App\Praticien\Categorie\Repo\CategorieKeywordEloquent(
                new \App\Praticien\Categorie\Entities\Categorie_keyword()
            );
        });
    }


    /**
     * Decision Worker
     */
    protected function registerDecisionWorkerService(){

        $this->app->singleton('App\Praticien\Decision\Worker\DecisionWorkerInterface', function()
        {
            return new \App\Praticien\Decision\Worker\DecisionWorker(
                \App::make('App\Praticien\Decision\Repo\DecisionInterface'),
                \App::make('App\Praticien\Decision\Repo\FailedInterface'),
                \App::make('App\Praticien\Categorie\Worker\CategorieWorkerInterface'),
                new \App\Praticien\Bger\Utility\Decision(),
                new \App\Praticien\Bger\Utility\Liste()
            );
        });
    }

    /**
     * Categorie Worker
     */
    protected function registerCategorieWorkerService(){

        $this->app->singleton('App\Praticien\Categorie\Worker\CategorieWorkerInterface', function()
        {
            return new \App\Praticien\Categorie\Worker\CategorieWorker(
                \App::make('App\Praticien\Decision\Repo\DecisionInterface')
            );
        });
    }


    /**
     * Search Worker
     */
    protected function registerSearchWorkerService(){

        $this->app->singleton('App\Praticien\Bger\Worker\SearchInterface', function()
        {
            return new \App\Praticien\Bger\Worker\Search(
                \App::make('App\Praticien\Decision\Repo\DecisionInterface'),
                new \App\Praticien\Bger\Utility\Clean()
            );
        });
    }

    /**
     * Alert Worker
     */
    protected function registerAlertWorkerService(){

        $this->app->singleton('App\Praticien\Bger\Worker\AlertInterface', function()
        {
            return new \App\Praticien\Bger\Worker\Alert(
                \App::make('App\Praticien\Decision\Repo\DecisionInterface'),
                \App::make('App\Praticien\User\Repo\UserInterface')
            );
        });
    }

    /**
     * Abo Worker
     */
    protected function registerAboWorkerService(){

        $this->app->singleton('App\Praticien\Abo\Worker\AboWorkerInterface', function()
        {
            return new \App\Praticien\Abo\Worker\AboWorker(
                \App::make('App\Praticien\Abo\Repo\AboInterface')
            );
        });
    }

    /**
     * User Worker
     */
    protected function registerUserWorkerService(){

        $this->app->singleton('App\Praticien\User\Worker\UserWorkerInterface', function()
        {
            return new \App\Praticien\User\Worker\UserWorker(
                \App::make('App\Praticien\User\Repo\UserInterface')
            );
        });
    }
}
