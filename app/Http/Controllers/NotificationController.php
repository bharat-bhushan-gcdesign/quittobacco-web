<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\User;
use App\Models\StaticNotification;

use Illuminate\Http\Request;

class StaticNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function send($message)
    {

        foreach (User::where('role',2)->get() as $user) {

            $this->sendfcm($message,$user->fcm_token);

            # code...
        }

    }
    public function sendfcm($message,$token){

        $url = 'https://fcm.googleapis.com/fcm/send';
        // $fields = array(
        //     'data' => array(
        //         "message" => $message
        //     ),
        //     'notification' => array(
        //         "title" => 'Notification',
        //         "body" => $message
        //     )
        // );
        
        $fields=array(
            'to' => $token,
            'data'=> [
                "title" => "WHO from data",
                "body" => $message,
            ],
            'notification'=>[
                "title" => "WHO from data",
                "body" => $message,
            ]
        );
        $firebase_key='AAAArK0_oPA:APA91bF0Dq8g3Rmtr18LscLTfI94rYqFx8QpqN2WVxgfLSQs97ntvc0nbWtOqBNoQ1LmJflLheA-cSoCQfuQ0m6hw56q80i4aaAR0CWuLDqAps4bFBCODtz1LXDBpNFOqTbhzjLEx3t7';
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
        // if($result===FALSE){
        //     die('curl failed:'.curl_error($ch));
        // }

        curl_close($ch);
        return $result;  

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaticNotification  $static_notification
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('static_notifications.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaticNotification  $static_notification
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        StaticNotification::create([
            'message'=>$request->message,
            'status'=>1
        ]);
        return redirect()->route('static_notifications.index')->with('success_message','Notification Stored Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaticNotification  $static_notification
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('static_notifications.index')->with('static_notifications',StaticNotification::all());
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaticNotification  $static_notification
     * @return \Illuminate\Http\Response
     */
    public function edit(StaticNotification $static_notification)
    {
        return view('static_notifications.create')->with('static_notification',$static_notification);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaticNotification  $static_notification
     * @return \Illuminate\Http\Response
     */
    public function publish(StaticNotification $static_notification)
    {

        
        $this->send($static_notification->message);
        return redirect()->back()->with('success_message','Notification Sent Successfully');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaticNotification  $static_notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,StaticNotification $static_notification)
    {
        // dd($request->all());
        $static_notification->update([
            'message'=>$request->message,
        ]);
        return redirect()->route('static_notifications.index')->with('success_message','Notification Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaticNotification  $static_notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaticNotification $static_notification)
    {
        $static_notification->delete();
        return redirect()->route('static_notifications.index')
                ->with('success_message','Notification deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\StaticNotification  $static_notification
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request,StaticNotification $static_notification)
    {
        if(is_object($static_notification)){
            $static_notification->update([
                'status'=>$request->status=="false" ? 0 : 1
            ]);
            return "success";
        }
        else
            return "failed";
    } 
      /**
     * Check Exist 
     *
     * @param  \App\StaticNotification  $static_notification
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return StaticNotification::where([
                'title'=>$request->title,
                'status'=>1
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }

   
}
