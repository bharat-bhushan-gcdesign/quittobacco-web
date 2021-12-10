<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\UserMotivation;
use Illuminate\Http\Request;
use App\Http\Resources\UserMotivationCollection;
use App\Http\Resources\UserMotivation as UserMotivationResource;
use Validator;

use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use DB;
use Illuminate\Support\Str;

class UserMotivationController extends Controller
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

    /** Return Profession request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'User Motivations Retrieved Successfully',
            'data'=>new UserMotivationCollection($user->user_motivations),
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
            'message' => 'required',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

        $user_motivations=DB::transaction(function() use ($request,$user){



            if($request->image !=null){
            $file = $request->image;
            @list($type, $image_data) = explode(';', $file);
            @list(, $image_data) = explode(',', $image_data); 
            $name = date('His').Str::random(5).'.'.'png';  
            file_put_contents(base_path() . '/public/uploads/userimages/'. $name, base64_decode($image_data));
            }else{
                $name='';
            }
            

            $user_motivations=UserMotivation::create([
                'message'=>$request->message,
                'user_id'=>$user->id,
                'status'=>1,
                'default_status'=>0,
                'image'=>$name 
            ]);

            return $user_motivations;
        });

    

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return UserMotivation request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Motivation Created Successfully',
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserMotivation  $user_motivations
     * @return \Illuminate\Http\Response
     */
    public function default(UserMotivation $user_motivation)
    {
        $user_motivations=UserMotivation::where('user_id',Auth::User()->id)->update([
            'default_status'=>0,
        ]);

        $user_motivation->update([
            'default_status'=>1,
        ]);

        return response()->json([
            'status' => 200,
            'message'=>'Motivation Updated Successfully',
        ]); 

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserMotivation  $user_motivations
     * @return \Illuminate\Http\Response
     */
    public function edit(UserMotivation $user_motivations)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserMotivation  $user_motivations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserMotivation $user_motivation)
    {

        $validator = Validator::make($request->all(), [
        'message' => 'required',
        // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);


    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

        $user_motivation=DB::transaction(function() use ($request,$user,$user_motivation){

            if(is_file($request->image)){
                $image_name = time().'.'.$request->image->getClientOriginalName();
                $request->image->move(public_path('images', $image_name ));
            }

             // if($request->image && $user_motivation->image != "")
             //    // dd($user_motivation->image);
             //    unlink(public_path('images', $user_motivation->image ));

            $user_motivation->update([
                'message'=>$request->message!=null ? $request->message : $user_motivation->message,
                'image'=>$request->image!=null ? $image_name : $user_motivation->image,
            ]);
              return $user_motivation;
        });


        /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  
        return response()->json([
            'status' => 200,
            'message'=>'Motivation Created Successfully',
            'data'=>new UserMotivationResource($user_motivation),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserMotivation  $user_motivation
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserMotivation $user_motivation)
    {
        $user_motivation->delete();

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return UserMotivation request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Motivation Deleted Successfully',
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }
    
}
