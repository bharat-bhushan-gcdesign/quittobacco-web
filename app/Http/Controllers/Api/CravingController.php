<?php

namespace App\Http\Controllers\Api;

use App\Models\Craving;
use App\Models\UserNotification;
use App\Models\Feeling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use Validator;
use App\Http\Resources\Craving as CravingResource;
use App\Http\Resources\CravingCollection;
use Carbon\Carbon;

class CravingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Cravings request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Cravings Retrieved Successfully',
            'data'=>$user->cravings !=null ? new CravingCollection($user->cravings->where('carving_status','1')->where('tobacco_rating','2'))  : "",
            'jwt_token'=>$token,
        ])->header('jwt_token', $token);
    }


    public function trigger()
    {

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Cravings request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Cravings Retrieved Successfully',
            'data'=>$user->cravings !=null ? new CravingCollection($user->cravings->where('carving_status','1'))  : "",
            'jwt_token'=>$token,
        ])->header('jwt_token', $token);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user =User::where('id',Auth::User()->id)->first();

        // if($request->carving_status == 1){  
            $validator = Validator::make($request->all(), [
                'with_whom_id' => 'required|exists:with_whoms,id',
                'feeling_id' => 'required|exists:feelings,id',
                'location' => 'required',
                'what_triggered_you' => 'required',
                'how_long_did_craving_lasted' => 'required',
            ]);
            if($request->feeling_type == 1)
            $validator = Validator::make($request->all(), [
                'other_feeling' => 'required',
            ]); 
        // }else
            $validator = Validator::make($request->all(), [
                'tobacco_rating' => 'required',
            ]);


        if($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        if($request->feeling_type == 1) 
            $feeling = Feeling::create([
                'name' => $request->other_feeling,
                'status' => 2,
            ]);


        $craving=Craving::updateOrCreate([
            'user_id'=>Auth::User()->id,
            'created_at' => Craving::whereDate('created_at', Carbon::today())->first()->created_at ?? null
        ],[
            'carving_status'=>$request->carving_status,
            'location'=>$request->location,
            'feeling_id'=> $request->feeling_type==1 ? $feeling->id : $request->feeling_id,
            'tobacco_rating'=>$request->tobacco_rating,
            'with_whom_id'=>$request->with_whom_id,
            'comments'=>$request->what_triggered_you,
            'rate'=>$request->how_long_did_craving_lasted, /** How strong you use tobacco */
            'status'=>1
        ]);

        if(isset($request->notification_id))
            UserNotification::where('id',$request->notification_id)->update([
                'seen_status'=>1, 
            ]);
       

        if($request->carving_status == 0)  
            return response()->json([
                'status' => 200,
                "tobacco_rating"=>$craving->tobacco_rating,'message'=>'Very good, you are successfully on track. Keep it up!',
                'message'=>'Very good, you are successfully on track. Keep it up!'
                
            ]); 
        /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Craving request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Craving Created Successfully',
            'data'=>new CravingResource($craving),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Craving  $craving
     * @return \Illuminate\Http\Response
     */
    public function show(Craving $craving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Craving  $craving
     * @return \Illuminate\Http\Response
     */
    public function edit(Craving $craving)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Craving  $craving
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Craving $craving)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Craving  $craving
     * @return \Illuminate\Http\Response
     */
    public function destroy(Craving $craving)
    {
        //
    }
}
