<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use JWTAuth;
use Auth;
use App\Models\UserInformation;
use DB;
class SettingController extends Controller
{

    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        /** Get Auth User **/
        $user_information=UserInformation::where('user_id',Auth::User()->id)->first();

        /** Get Review For User **/
           $user_information->update([
                    'first_tobacco_use_age'=>"",
                    'money_spent'=>"",
                    'tobacco_count'=>"",
                    'how_hard_to_quit'=>"",
                    'quit_date'=>"",
                    'quit_reasons'=>[],
                    'use_reasons'=>[],
                    'usage_count'=>"",
                ]);
            return response()->json([
                'questionarie_status'=>0,
                'status' => $this->created,
                'message' => 'Settings Resetted sucessfully.'
            ]);
    }

  
}