<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\UserNotification;
use App\Models\UserAchievement;
use Illuminate\Http\Request;
use App\Http\Resources\Achievement as AchievementResource;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use Carbon\Carbon;
use App\Models\Craving;

class AchievementController extends Controller
{
    /**
     * Display a listing of the source.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

   
    }

    /**
     * Show the form for creating a new source.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         /** Get user by secret code */

       
        $user =User::where('id',Auth::User()->id)->first();

        $token = JWTAuth::fromUser($user);  
            $user_achievement = UserAchievement::firstOrCreate([
                'user_id'=>$user->id,
                'achievement_id'=>$request->achievement_id,
                'status'=>1
            ]);
            UserNotification::where('id',$request->notification_id)->update([
                'seen_status'=>1, 
            ]);
        return response()->json([
            'status' => 200,
            'message'=>'Achievement Retrieved Successfully',
            'data'=>['quit_date'=>($user->user_information != null)?(new Carbon($user->user_information->quit_date))->format('d M Y h:i:s a') : "",
                    'week'=>$request->achievement_id, 
                    'image'=>$user_achievement->achievement->image],
            'jwt_token'=>$token,
        ])->header('jwt_token', $token);
    }

    /**
     * Display the specified source.
     *
     * @param  \App\Models\Achievement  $Achievement
     * @return \Illuminate\Http\Response
     */
    public function show(Achievement $Achievement)
    {
        $user =User::where('id',Auth::User()->id)->first();

        
        $token = JWTAuth::fromUser($user);  
        
        return response()->json([
            'status' => 200,
            'message'=>'Achievement Retrieved Successfully',
            'data'=>['quit_date'=>($user->user_information != null)?(new Carbon($user->user_information->quit_date))->format('d M Y h:i:s a') : "",
            'achievement'=>Achievement::whereIn('id',$user->user_achievements->pluck('achievement_id'))->get()],
            'jwt_token'=>$token,
        ])->header('jwt_token', $token);
        
    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\Achievement  $Achievement
     * @return \Illuminate\Http\Response
     */
    }
    public function edit(Achievement $Achievement)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Achievement  $Achievement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Achievement $Achievement)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\Achievement  $Achievement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achievement $Achievement)
    {
        //
    }
}
