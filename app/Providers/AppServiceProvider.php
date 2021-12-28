<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use URL;
use Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // added to force serveing js & css files over https
        //$this->app['request']->server->set('HTTPS','on');
        URL::forceScheme('https');

        Relation::morphMap([
            'users'=>'App\User',
            'plans'=>'App\Models\Plan',
            'motivations'=>'App\Models\Motivation',
            'wish_lists'=>'App\Models\WishList',

        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
