<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Motivation;
use Illuminate\Http\Request;
use App\Http\Resources\MotivationCollection;
use App\Http\Resources\Motivation as MotivationResource;
use Validator;
use Illuminate\Support\Str;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use DB;

class MotivationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //     /** Get user by secret code */
    //     $user =User::where('id',Auth::User()->id)->first();

    // /** Generate token for Auth User */
    //     $token = JWTAuth::fromUser($user);  

    // /** Return Profession request data with token */
    //     return response()->json([
    //         'status' => 200,
    //         'message'=>'Motivations Retrieved Successfully',
    //         'data'=>new MotivationCollection($user->motivations),
    //         'jwt_token'=>$token,
    //     ])->header('jwt_token', $token);
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
            // 'motivation_request' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

        $motivation=DB::transaction(function() use ($request,$user){


            $motivation=Motivation::firstOrCreate([
                'request'=>ucwords(strtolower($request->motivation_request)),
                'user_id'=>$user->id,
                'status'=>1
            ]);

             /** Create profile image for customer*/
            if($request->image!=null){

                @list($type, $file_data) = explode(';', $request->input('image'));

                @list(, $file_data) = explode(',', $file_data); 

                $imageName   = $user->code.$user->id.Str::random(5).'.'.'png'; 

                file_put_contents(base_path() . '/public/uploads/files/'. $imageName, base64_decode($file_data));

                $motivation->file()->save(new \App\Models\File([
                    'name' =>$imageName, 
                ]));
            }

            return $motivation;
        });

    

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Motivation request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Motivation Created Successfully',
            'data'=>new MotivationResource($motivation),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function show(Motivation $motivation)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function edit(Motivation $motivation)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motivation $motivation)
    {

        $validator = Validator::make($request->all(), [ 
            'motivation_request' => 'required',
            
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);


    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

       $motivation=DB::transaction(function() use ($request,$user,$motivation){


            $motivation->update([
                'request'=>$request->motivation_request!=null ? ucwords(strtolower($request->motivation_request)) : $request->motivation_request,
            ]);


            $image = $request->file('image');
            $name="";
                  
             /** Create profile image for customer*/
            if($request->image!=null){

                @list($type, $file_data) = explode(';', $request->input('image'));

                @list(, $file_data) = explode(',', $file_data); 

                $imageName   = $user->code.$user->id.Str::random(5).'.'.'png'; 

                file_put_contents(base_path() . '/public/uploads/files/'. $imageName, base64_decode($file_data));
                unlink(public_path('uploads/files/' . $motivation->file->name));

                $motivation->file->update([
                    'name' =>$imageName, 
                ]);

            }
            

            return $motivation;
        });
       
        
   

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Motivation request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Motivation Updated Successfully',
            'data'=>new MotivationResource($motivation),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Motivation $motivation)
    {
        $motivation->delete();

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Motivation request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Motivation Deleted Successfully',
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }
    
}
