<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\Models\UserNotification;
use App\Models\Diary;
use App\Models\Mission;
use App\Models\UserInformation;

use App\Models\Achievement as Achievements;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Achievement;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use Validator;
use Carbon\Carbon;
use App\Http\Resources\Notification as NotificationResource;
use App\Http\Resources\UserNotificationCollection;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function send_notification($token,$message,$type,$achievement_id)
    {
        $url='https://fcm.googleapis.com/fcm/send';
       
        $firebase_key='AAAArK0_oPA:APA91bF0Dq8g3Rmtr18LscLTfI94rYqFx8QpqN2WVxgfLSQs97ntvc0nbWtOqBNoQ1LmJflLheA-cSoCQfuQ0m6hw56q80i4aaAR0CWuLDqAps4bFBCODtz1LXDBpNFOqTbhzjLEx3t7';

        // $fields=array(
        //     'to' => 'ePEUg28gRfiZ3JbypKBs5q:APA91bGSyL4Fr31_b2EpOiQkRmIDIkGOhvk1LIr2qehjBE0NFcOJfNmKeJyWZJOvEcIZQV61l4na_7cF0cwdwtWWcglAAaZm_m5-DsdjtxdakIiz1ziHU48Y1zChZkBP8M_C3EZLPl-4',
        //     'data'=>[
        //         "message" => "fsggtdhfrttjgjgj jgghgj "
        //     ],
        // );

        $fields=array(
            'to' => $token,
            'data'=> [
                "body" => $message,
                'type'=>$type,
                'achievement_id'=>$achievement_id
            ],
            'notification'=>[
                "body" => $message,
                'achievement_id'=>$achievement_id
            ]
        );

        $headers=array(
            'Authorization:key='.$firebase_key,
            'Content-Type: application/json'
        );

        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
        $result=curl_exec($ch);
        if($result===FALSE){

            die('curl failed:'.curl_error($ch));
        }
        curl_close($ch);
        
        // return $result;                                               
    }

     /**
     * Diary Reminder based on Diary Time
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */

    public function diary_remainder($user_id)
    {   

        $user=User::where('id',$user_id)->first();

        $message = "Diary Reminder";

        if(Diary::where('user_id',$user->id)->whereDate('created_at', Carbon::today())->first() ==null){
            $this->send_notification($user->fcm_token,$message,1,'');
            $this->store(1,$user->id,$message,'','',1,'');// 2=> Acheivement
        }
    } 
    /**
     * Diary Reminder based on Diary Time
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */

    public function general()
    {   

        $users=User::where('status','!=',2)
                ->where('role', 2)
                ->get();

        $message = "Did you use tobacco today?";

        foreach ($users as  $user) {

            if(@$user->notification->general_alert==1){
                $this->send_notification($user->fcm_token,$message,1,"");
                $this->store(1,$user->id,$message,"no","yes",2,""); // 1=>Craving(Daily  Message)
            }
        }   
    } 

     /**
     * Mission Reminder
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */

    public function mission_remainder($user_id)
    {   

        $user=User::where('id',$user_id)->first();

        $message = "Plan Reminder";

        if(Mission::where('user_id',$user->id)->whereDate('created_at', Carbon::today())->first() ==null){
            $this->send_notification($user->fcm_token,$message,1,'');
            $this->store(1,$user->id,$message,'','',1,'');// 2=> Acheivement
        }
    } 

    /**
     * Filter User Based on Date
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */

    public function acheievement()
    {  
        
        $users=User::where('status','!=',2)
                ->where('role', 2)
                ->get();

        foreach ($users as  $user){

            if($user->user_information != null && ($user->user_information->start_date!=null && $user->user_information->quit_date!=null)){
                $start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $user->user_information->start_date);
                $end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $user->user_information->quit_date);
                $divided_date = $start_date->diffInDays($end_date);
            }


            $achievement = Achievements::where('days',$divided_date)->first();


            // $sub_days = 0;

            // $message = '';
            // $type=1;
            if($divided_date == 2){
                $sub_days = 2;
                $type =2;/*2=>with yes or no*/
                $message = "Day 1 is over! Did you QUIT today?";
                $positive = 'yes';
                $negative = 'no';
            }

            elseif($divided_date == 4 ){
                $sub_days = 4;
                $type =2;/*2=>with yes or no*/
                $message = "4 days Tobacco free! The first few days can be tough. Try to relax. Listen to music, have fresh vegetables, fruits, do yoga or deep breathing.";
                $positive='Good';
                $negative='Not so Good';
            }
            elseif($divided_date == 5){
                $sub_days = 5;
                $type =2;/*2=>with yes or no*/
                $message = "What is your current level of craving (urge) to use tobacco?";
                $positive='Low';
                $negative='High';
            }
            elseif($divided_date == 16){
                $sub_days = 16;
                $type =2;/*2=>with yes or no*/
                $message = "16 days! Tobacco use never solved any problem for you. YOU DID IT. You can do great things, so think positively. How are you feeling today?";
                $positive='Good';
                $negative='Not so Good';
            }
            elseif($divided_date == 30){
                $sub_days = 30;
                $type =3;/*1=>without yes or no*/
                $message = "Congrats-1 MONTH Tobacco FREE! Major milestone. Share the good news with your family and friends. Do something special!";
                
            }
             elseif($divided_date == 31){
                $type =2;/*2=>with yes or no*/
                $sub_days = 31;
                $message = "Now that you are nearing the end of our text programme, what is your craving level?";
                $positive='Low';
                $negative='High';
            }
            elseif($divided_date == 32){
                $sub_days = 32;
                $type =2;/*2=>with yes or no*/
                $message = "Well done! We are proud of you! Do you think it will be hard to stay Tobacco free?";
                $positive='Easy';
                $negative='Difficult';
            }
            elseif($divided_date == 91){
                $sub_days = 91;
                $type =2;/*2=>with yes or no*/
                $message = "Hi, it has been 3 months. Are you tobacco free or back to using tobacco?";
                $positive='Free';
                $negative='Back';
            }
            elseif($divided_date == 182){
                $sub_days = 182;
                $type =2;/*2=>with yes or no*/
                $message = "It has been 6 months. Checking on how you are doing for a LAST time! Are you still tobacco free or back to using tobacco?";
                $positive='Free';
                $negative='Back';
            }else
                $sub_days=0;

           

            if($sub_days!=0){
                
                $user_information=UserInformation::where('user_id',$user->id)
                    ->whereDate('created_at' , '>=', Carbon::today()->subDays( $sub_days ))
                    ->first();
                $user=@$user_information->user;
                    
                   


                if($user!=null && @$user->notification->general_alert==1){

                    $this->send_notification($user->fcm_token,$message,$type,@$achievement->id);

                    $this->store(2,$user->id,$message,@$positive,@$negative,$type,@$achievement->id);// 2=> Acheivement
                }
            }
             if($user->cravings !=null && (($user->cravings->count() && $user->cravings->where('carving_status',0)->count())==$divided_date)){
                $sub_days=1;
                $divided_date=0;
                $message = "You have been Completed Your Milestone Successfully!!!";
                $type =1;
            }
        } 
    }

    /**
     *  User Notification Store
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($type,$user_id,$message,$positive,$negative,$notify_type,$achievement_id)
    {


        /** Create new notification */
            $notification=UserNotification::create([
                'type'=>$type,/*1=>daily message 2=> general message */
                'notify_type'=>$notify_type, /*1=>without yes or no 2=> with yes r no */
                'user_id'=>$user_id,
                'status'=>1,
                'message'=>$message,
                'achievement_id'=>$achievement_id,
                'positive'=>$positive,
                'negative'=>$negative,
                'seen_status'=>0, 
                    
            ]);
            return $notification;
        // });
    }


    public function seen_statusUpdate(Request $request ,UserNotification $user_notification)
    {

         // $notification=DB::transaction(function() use ($type,$user_id,$message){

        /** Create new notification */
           $user_notification->update([
                'seen_status'=>1, 
                    
            ]);

            return $user_notification;
        // });
    }





    /**
     * User Notification index- History
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
     return response()->json([
            'status' => 200,
            'message'=>'Notification retrieved Successfully',
            'data'=>Auth::User()->user_notifications !=null ? new UserNotificationCollection(Auth::User()->user_notifications) : [],
        ]); 
    }
    /**
     * Notification Setting View
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       
    /** Return Notification request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Notification updated Successfully',
            'data'=>Auth::User()->notification !=null ? new NotificationResource(Auth::User()->notification) : [],
        ]); 
    }

    /**
     * Notification Settings Update
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {

        $validator = Validator::make($request->all(), [
            'diary_remainder' => 'required|numeric',
            'diary_remainder_time' => 'required',
            'mission_remainder' => 'required|numeric',
            'mission_remainder_time' => 'required',
            'badge' => 'required|numeric',
            'general_alert' => 'required|numeric',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        $notification=Notification::updateOrCreate([
            'user_id'=>Auth::User()->id,
        ],[
            'diary_remainder' =>$request->diary_remainder, 
            'diary_remainder_time' => $request->diary_remainder_time != null  ?  $request->diary_remainder_time : "18:30", 
            'mission_remainder' =>$request->mission_remainder,  
            'mission_remainder_time' => $request->mission_remainder_time != null  ?  $request->mission_remainder_time : "20:00", 
            'badge' =>$request->badge, 
            'general_alert' => $request->general_alert,
            'status' =>1
        ]);

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Notification request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Notification Updated Successfully',
            'data'=>new NotificationResource($notification),
        ]); 
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 //    public function create()
 //    {

 //        $users=User::where('status','!=',2)
 //            ->where('role', 2)
 //            ->whereDate('created_at', Carbon::today())
 //            ->get();

 //        $message = [
 //            'message'=>"Day 1 is almost over! Did you QUIT today?",
 //            'achievement'=>Achievement::where('week',1)->first()->id
 //        ]; 

 //        foreach ($users as  $user) {
 //            $this->send_notification($user->fcm_token,$message);
 //        }
 //    }


 //    public function fourth_day(){

	//     $users=User::where('status','!=',2)
 //            ->where('role', 2)
 //            ->whereDate('created_at' , '>=', Carbon::today()->subDays( 4 ))
 //            ->get();

	//     $message = [
	//         'message'=>" 4 days Tobacco free! The first few days can be tough. Try to relax. Listen to music, have fresh vegetables, fruits, do yoga or deep breathing.How do you feel?",
 //            'achievement'=>Achievement::where('week',1)->first()->id
	//     ]; 
	//     foreach ($users as  $user)
 //            if($user->notification->general_alert==1)
	//            $this->send_notification($user->fcm_token,$message);
	// }


 //    public function sixteenth_day(){ 

	//     $users=User::where('status','!=',2)
 //            ->where('role',2)
 //            ->whereDate('created_at' , '>=', Carbon::today()->subDays( 16 ))
 //            ->get();

 //        $message = [
 //            'message'=>"16 days! Tobacco use never solved any problem for you. YOU DID IT. You can do great things, so think positively. How are you feeling today?",
 //            'achievement'=>Achievement::where('week',2)->first()->id
 //        ]; 

 //        foreach ($users as  $user) 
 //            if($user->notification->general_alert==1)
 //         	  $this->send_notification($user->fcm_token,$message);
 //    }

 //    public function one_month(){ 

 //      	$users=User::where('status','!=',2)
 //            ->where('role', 2)
 //            ->whereDate('created_at' , '>=', Carbon::today()->subDays( 30 ))
 //            ->get();

 //        $message = [
 //            'message'=>"Congrats--1 MONTH Tobacco FREE! Major milestone. Share the good news
	// 				with your family and friends. Do something special!"
 //        ]; 

 //        foreach ($users as  $user) 
 //            if($user->notification->general_alert==1)
 //         	  $this->send_notification($user->fcm_token,$message);
 //    }

 //    public function third_month(){ 

 //        $users=User::where('status','!=',2)
 //            ->where('role', 2)
 //            ->whereDate('created_at' , '>=', Carbon::today()->subDays( 91 ))
 //            ->get();

 //        $message = [
 //            'message'=>"Hi, it has been 3 months. Are you tobacco free or back to using tobacco?"
 //        ]; 

 //        foreach ($users as  $user) 
 //            if($user->notification->general_alert==1)
 //             $this->send_notification($user->fcm_token,$message);
 //    }

 //    public function sixth_month(){ 

 //        $users=User::where('status','!=',2)
 //            ->where('role', 2)
 //            ->whereDate('created_at' , '>=', Carbon::today()->subDays( 182 ))
 //            ->get();

 //        $message = [
 //            'message'=>"It has been 6 months. Checking on how you are doing for a LAST time! Are you still tobacco free or back to using tobacco?"
 //        ]; 

 //        foreach ($users as  $user) 
 //            if($user->notification->general_alert==1)
 //             $this->send_notification($user->fcm_token,$message);
 //    }







    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
