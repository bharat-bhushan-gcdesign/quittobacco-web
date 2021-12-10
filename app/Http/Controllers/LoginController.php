<?php

namespace App\Http\Controllers;

use Azure;
use Auth;
class LoginController
{
    public function login()
    {
        return Azure::redirect();
    }

    public function handleCallback()
    {

        $token = Azure::getAccessToken('authorization_code', [
            'code' => $request->code,
            'resource' => 'https://graph.windows.net',
        ]);
        \Log::info($token.'Asshiii');

        $resourceOwner = Azure::getResourceOwner($token);
        // echo 'Hello, '.$resourceOwner->getEmail().'!';
        $user=User::where('email',$resourceOwner->getEmail())->first();
        \Log::info($user);
        if($user!=null)
            $user->update(['azure_id'=>$token]);
        $token = Azure::getAccessToken('authorization_code', [
            'code' => $_GET['code'],
            'resource' => 'https://graph.windows.net',
        ]);

        try {
            // We got an access token, let's now get the user's details
              $me = Azure::get("me", $token);

        } catch (\Exception $e) {
            //
        }

        // Use this to interact with an API on the users behalf

        echo $token->getToken();
    }

    public function logout()
    {
        Auth::logout();
        $redirect_url = "https://whoapp.dci.in/login";
        return redirect(Azure::getLogoutUrl($redirect_url));
    }
}
