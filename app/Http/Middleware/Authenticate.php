<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('api/*')) {
                return route('api.jwt.unauthorized');
            }

            return route('login');
            // return route('login')->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
            // ->header('Pragma','no-cache')
            // ->header('Expires','Sat, 26 Jul 1997 05:00:00 GMT');
        }
    }
}
