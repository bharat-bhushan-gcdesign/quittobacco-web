<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Resources\FeedbackCollection;
use App\Http\Resources\Feedback as FeedbackResource;
use Validator;

use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use DB;
class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'message' => 'required',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

        $feedback=DB::transaction(function() use ($request,$user){


            $feedback=Feedback::firstOrCreate([
                'message'=>ucwords(strtolower($request->message)),
                'email'=>$request->email,
                'user_id'=>$user->id,
                'status'=>1
            ]);

            return $feedback;
        });

        $this->sendNotification($request);
    

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Feedback request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Feedback Submitted Successfully',
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {

    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendNotification(Request $request)
    {
        $firebaseToken = User::where('role',1)->whereNotNull('fcm_token')->pluck('fcm_token')->all();
          
        $SERVER_API_KEY = 'AAAAskK-YQ4:APA91bE9U2565Y0xnABhQw0rrXpaqcphVyeTMtaYL_GbjOtXTxgn0PeTykY4ZSEwNlJYq6Ukx8fyTp6GwHA-NcZAafcVRDnSZnaS9cZ--ZJpNnCx0E6OMuDiU1aA18VYBNUB48Aw1fPe';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "Feedback from " .$request->email,
                "body" => $request->message,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        return $response;
    }
    
}
