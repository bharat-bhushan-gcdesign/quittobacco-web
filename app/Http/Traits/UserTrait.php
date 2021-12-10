<?php
namespace App\Http\Traits;
use Illuminate\Support\Str;

trait UserTrait {

    function generateOTP($user){
        $user->otp=env('APP_ENV') == 'production'
                ? rand(1000, 9999)
                : 1111;
        $user->save();
    }
}
