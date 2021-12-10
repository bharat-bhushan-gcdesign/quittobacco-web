<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;
use Azure;
class AzureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        // \Log::info('From azure_id');

        $user=Auth::User();
        \Log::info($user);
        try {
        
        if($user->azure_id!=null){

                // $resourceOwner = Azure::getResourceOwner($user->azure_id);
                // if($user->email==$resourceOwner->getEmail())
                    return $next($request);
           
        }else
            abort(403);
             }catch (\Exception $e) {
                abort(403);
            }
          
        
       
    }
}
