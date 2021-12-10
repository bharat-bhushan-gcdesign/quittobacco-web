<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\UserInformation;
use App\Models\Saving;
use App\Models\HealthImprovement;
use Illuminate\Http\Request;
use App\Http\Resources\UserInformationCollection;
use App\Http\Resources\UserInformation as UserInformationResource;
use Validator;
use Carbon\Carbon;

use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use DB;
class UserInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //
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
            'education_id'=> 'required|exists:educations,id',
            'profession_id'=> 'required|exists:professions,id',
            'tobacco_id'=> 'required|exists:tobaccos,id',
            'tobacco_product_id'=> 'required|exists:tobacco_products,id',
            'frequent_smoke_id'=> 'required|exists:frequent_smokes,id',
            'first_smoke_timing_id'=> 'required|exists:first_smoke_timings,id',
            'first_tobacco_use_age'=> 'required', /** what age did you first use tobacco */
            'money_spent'=> 'required', /** How much spent for tobacco per day */
            'usage_count'=> 'required', /** How many time do you use tobacco in a day */
            'tobacco_count'=> 'required',
             /** How many pieces do you use tobacco in a day */
            // 'how_hard_to_quit'=> 'required', /** 0->Easy,1->Not so difficult, 2-> Very Difficult */
            'country_id'=> 'required', /** How many pieces do you use tobacco in a day */
            'gender'=> 'required',
            'use_reasons'=> 'required|exists:use_reasons,id',
            'date_of_birth'=> 'required',
            // 'quit_date'=> 'required',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();
     

        $user_information=DB::transaction(function() use ($request,$user){



            $user_information=UserInformation::firstOrCreate([
                'user_id'=>Auth::User()->id, 
            ],[

                'education_id'=>$request->education_id,
                'profession_id'=>$request->profession_id,
                'tobacco_id'=>$request->tobacco_id,
                'tobacco_product_id'=>$request->tobacco_product_id,
                'frequent_smoke_id'=>$request->frequent_smoke_id,
                'first_smoke_timing_id'=>$request->first_smoke_timing_id,
                'quit_reasons'=>$request->quit_reasons,
                'first_tobacco_use_age'=>$request->first_tobacco_use_age, /** what age did you first use tobacco */
                'money_spent'=>$request->money_spent, /** How much spent for tobacco per day */
                'usage_count'=>$request->usage_count, /** How many time do you use tobacco in a day */
                'tobacco_count'=>$request->tobacco_count, /** How many pieces do you use tobacco in a day */
                // 'how_hard_to_quit'=>$request->how_hard_to_quit, /** 0->Easy,1->Not so difficult, 2-> Very Difficult */
                'country_id'=> $request->country_id,
                'use_reasons'=>$request->use_reasons,
                'education_id'=>$request->education_id,
                'tobacco_id'=>$request->tobacco_id,
                'quit_timestamp'=>$request->quit_timestamp,
                'gender'=>$request->gender,
                'date_of_birth'=>$request->date_of_birth,
                'start_date'=>Carbon::now()->format('Y-m-d'),
                'status'=>1 /** 0 => Inactive 1 => Active*/
            ]);
            $saving=Saving::firstOrCreate([
                'user_id'=>Auth::User()->id, 
            ],[
                'per_day'=>$user_information->money_spent,
                'per_week'=>$user_information->money_spent * 7,
                'per_month'=>$user_information->money_spent * 30,
                'per_year'=>$user_information->money_spent * 364,
                'status'=>1 /** 0 => Inactive 1 => Active*/
            ]);
            $health_improvement=HealthImprovement::firstOrCreate([
                'user_id'=>Auth::User()->id, 
            ],[
                'oxygen_level'=>1,
                'lungs'=>2,
                'carbon_monoxide_level'=>3,
                'status'=>1 /** 0 => Inactive 1 => Active*/
            ]);
            return $user_information;
        });

        if(Auth::User()->notification==null)
            Auth::User()->notification()->save(new \App\Models\Notification([
                'diary_remainder' =>1, 
                'diary_remainder_time' =>"18:30", 
                'mission_remainder' =>1,  
                'mission_remainder_time' =>  "20:00", 
                'badge' =>1, 
                'general_alert' =>1,
                'status' =>1
            ]));
     

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return UserInformation request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'User Information Created Successfully',
            'data'=>new UserInformationResource($user_information),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserInformation  $user_information
     * @return \Illuminate\Http\Response
     */
    public function show(UserInformation $user_information)
    {
        return response()->json([
            'status' => 200,
            'message'=>'User Information Retrieved Successfully',
            'data'=>new UserInformationResource(Auth::User()->user_information),
        ]); 

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserInformation  $user_information
     * @return \Illuminate\Http\Response
     */
    public function edit(UserInformation $user_information)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserInformation  $user_information
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserInformation $user_information)
    {
        $validator = Validator::make($request->all(), [
            'education_id'=> 'nullable',
            'profession_id'=> 'nullable',
            'tobacco_id'=> 'nullable',
            'tobacco_product_id'=> 'nullable',
            'frequent_smoke_id'=> 'nullable',
            'first_smoke_timing_id'=> 'nullable',
            'first_tobacco_use_age'=> 'nullable', /** what age did you first use tobacco */
            'money_spent'=> 'nullable', /** How much spent for tobacco per day */
            'usage_count'=> 'nullable', /** How many time do you use tobacco in a day */
            'tobacco_count'=> 'nullable', /** How many pieces do you use tobacco in a day */
            'how_hard_to_quit'=> 'nullable', /** 0->Easy,1->Not so difficult, 2-> Very Difficult */
            'gender'=> 'nullable',
            'quit_timestamp'=>'nullable',

            'date_of_birth'=> 'nullable',
            'use_reasons'=>'nullable',
            'country_id'=>'nullable',
            'quit_reasons'=>'nullable',
            'quit_date'=> 'nullable',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);


    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();
        $user_information=$user->user_information;
        $user_information=DB::transaction(function() use ($request,$user,$user_information){



            $user_information=UserInformation::updateOrCreate([ 
                'user_id'=>Auth::User()->id
            ],[


                'education_id'=>$request->education_id !=null ? $request->education_id : ($user_information!=null ? $user_information->education_id : ""),
                'profession_id'=>$request->profession_id !=null ? $request->profession_id : ($user_information!=null ? $user_information->profession_id : ""),

                'tobacco_id'=>$request->tobacco_id !=null ? $request->tobacco_id : ($user_information!=null ? $user_information->tobacco_id : ""),

             

                'tobacco_product_id'=>$request->tobacco_product_id !=null ? $request->tobacco_product_id : ($user_information!=null ? $user_information->tobacco_product_id : []),

                'frequent_smoke_id'=>$request->frequent_smoke_id !=null ? $request->frequent_smoke_id : ($user_information!=null ? $user_information->frequent_smoke_id : ""),

                'first_smoke_timing_id'=>$request->first_smoke_timing_id !=null ? $request->first_smoke_timing_id : ($user_information!=null ? $user_information->first_smoke_timing_id : "")  ,

                'first_tobacco_use_age'=>$request->first_tobacco_use_age !=null ? $request->first_tobacco_use_age : ($user_information!=null ? $user_information->first_tobacco_use_age : ""), /** what age did you first use tobacco */
                'money_spent'=>$request->money_spent !=null ? $request->money_spent : ($user_information!=null ? $user_information->money_spent : ""), /** How much spent for tobacco per day */
                'usage_count'=>$request->usage_count !=null ? $request->usage_count : ($user_information!=null ? $user_information->usage_count : ""), /** How many time do you use tobacco in a day */
                'tobacco_count'=>$request->tobacco_count !=null ? $request->tobacco_count : ($user_information!=null ? $user_information->tobacco_count : ""), /** How many pieces do you use tobacco in a day */
                'how_hard_to_quit'=>$request->how_hard_to_quit !=null ?  $request->how_hard_to_quit : ($user_information!=null ? $user_information->how_hard_to_quit : ""), /** 0->Easy,1->Not so difficult, 2-> Very Difficult */
                'gender'=>$request->gender !=null ? $request->gender : ($user_information!=null ?  $user_information->gender : ""),
                'date_of_birth'=>$request->date_of_birth !=null ? $request->date_of_birth : ($user_information!=null ? $user_information->date_of_birth  : ""),
                'quit_date'=>$request->quit_date !=null ? $request->quit_date : ($user_information!=null ? $user_information->quit_date : ""),
                'start_date'=>$user_information!=null ? Carbon::now()->format('Y-m-d') : "",

                'quit_date_time'=>$request->quit_date_time !=null ? $request->quit_date_time : ($user_information!=null ? $user_information->quit_date_time : ""),

                'country_id'=>$request->country_id !=null ? $request->country_id : ($user_information!=null ? $user_information->country_id : ""),

                'use_reasons'=>$request->use_reasons !=null ? $request->use_reasons : ($user_information!=null ? $user_information->use_reasons : []),
                'quit_timestamp'=>$request->quit_timestamp !=null ? $request->quit_timestamp : ($user_information!=null ? $user_information->quit_timestamp : ""),

                
                'status'=>1 /** 0 => Inactive 1 => Active*/
            ]);


            return $user_information;
        });
       
        
            // return $user_information;
   

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return UserInformation request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'User Information Updated Successfully',
            'data'=>new UserInformationResource($user_information),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserInformation  $user_information
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInformation $user_information)
    {
        $user_information->delete();

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return UserInformation request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'User Information Deleted Successfully',
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }
    
}
