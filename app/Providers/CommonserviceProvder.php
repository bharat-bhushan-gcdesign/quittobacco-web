<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;

class CommonserviceProvder extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      
            
         //  dd(Auth::user());
                
      
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    
        public function boot()
    {
        view()->composer('*', function ($view) {
           // dd(Auth::user()->status);
          if (Auth::user() !='')
           {
             if(Auth::user()->status!=1)
             {
               Auth::logout();
               return redirect('/login');
             }
          }
        });
    }
            
    
}
