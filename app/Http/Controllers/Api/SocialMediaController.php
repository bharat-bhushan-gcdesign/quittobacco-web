<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SocialMediaUser as SocialMediaUserResource;
use App\Http\Resources\User as UserResource;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use Validator;
use App\Http\Requests\UserRequest;
use App\Http\Requests\AuthRequest;

class SocialMediaController extends Controller
{
    /**
     * Social Media user login
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'social_media_id' => 'required|unique:users,social_media_id',
            'type'=>'required',
            'fcm_token'=>'required'
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        $user=User::where('social_media_id',$request->social_media_id)->first();
        if($user!=null){

        }else{
            $user=User::firstOrCreate([
                'social_media_id'=>$request->social_media_id,
                'role'=>$request->type,
                'email'=>$request->email,
                'mobile'=>$request->mobile,
                'name'=>$request->name,
                'fcm_token'=>XVXCFGVFCD,
                'role'=>2,
                'status'=>1
            ]);
        }
        

    /** Get user by secret code */
        $user =User::where('id',$user->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Profession request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'User logined Successfully',
            'data'=>new SocialMediaUserResource($user),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Social Media user login
     *
     * @return \Illuminate\Http\Response
     */
    public function login(UserRequest $request)
    {

        $user=User::where('social_media_id',$request->social_media_id)->first();

        
        if($user!=null && (($user->email!=$request->email && $user->email != "") || ($user->mobile!=$request->mobile && $user->mobile != "")))
            return response()->json([
                'status' => 500, 
                'message' => 'This Account is already synced with Another Account'
            ]);

        elseif($user != null && (($user->email== $request->email && $user->email != "")|| ($user->mobile==$request->mobile && $user->mobile != ""))){

            $token =    Auth::guard('api')->fromUser($user);
            /** Return Profession request data with token */
            return response()->json([
                'status' => 200,
                'message'=>'User logined Successfully',
                'data'=>new UserResource($user),
                'jwt_token'=>$token,
            ])->header('jwt_token', $token); 
        }
        $request->type=2;
            

        // return \Request::route()->getName();
        $validator = Validator::make($request->all(), [
            'social_media_id' => 'required',
             
        ]);

        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);



        $email_user=User::where('email',$request->email)->where('email','!=',null)->first();
        $mobile_user=User::where('mobile',$request->mobile)->where('mobile','!=',null)->first();


    
        /** If email already exists */

            if($email_user!=null){
        /** If email and social media already exists */
                if(User::where(['email'=>$request->email,'social_media_id'=>$request->social_media_id])->exists()){

                    /** Get user by secret code */
                        $email_user=User::where(['email'=>$request->email,'social_media_id'=>$request->social_media_id])->first();

                }else{
                    if(User::where(['email'=>$request->email,'social_media_id'=>$request->social_media_id])->exists()){
                        return response()->json([
                            'status' => 500, 
                            'message' => 'This Account is already synced with Another Account'
                        ]);

                    }else{
                        $email_user->update([
                            'social_media_id'=>$request->social_media_id,
                            'status'=>1
                        ]);
                    }
                }
            }
            elseif($mobile_user!=null){
                if(User::where(['mobile'=>$request->mobile,'social_media_id'=>$request->social_media_id])->exists()){

                    /** Get user by secret code */
                        $mobile_user=User::where(['mobile'=>$request->mobile,'social_media_id'=>$request->social_media_id])->first();

                }else{
                    if(User::where(['mobile'=>$request->mobile,'social_media_id'=>$request->social_media_id])->exists()){
                        return response()->json([
                            'status' => 500, 
                            'message' => 'This Account is already synced with Another Account'
                        ]);

                    }else{
                        $mobile_user->update([
                            'social_media_id'=>$request->social_media_id,
                            'status'=>1
                        ]);
                    }
                }



            }else{
                if(User::where(['social_media_id'=>$request->social_media_id])->exists()){
                    return response()->json([
                        'status' => 500, 
                        'message' => 'This Account is already synced with Another Account'
                    ]);

                }else{
                    return (new UserController)->store($request);
                
                }
            }

        /** Chech Auth User Account **/

            if((isset($mobile_user) && $mobile_user->status!=1) || (isset($email_user) && $email_user->status!=1))
                return response()->json([
                    'status' => 500, 
                    'message' => 'Your Account was Deleted or Inactive'
                ]);

        /** Get user by secret code */
            $user =User::where('id',$mobile_user !=null ? $mobile_user->id : $email_user->id)->first();

        /** Generate token for Auth User */
            //$token = Auth::guard('api')->fromUser($user);
            $token = JWTAuth::fromUser($user);  

        /** Return Profession request data with token */
            return response()->json([
                'status' => 200,
                'message'=>'User logined Successfully',
                'data'=>new UserResource($user),
                'jwt_token'=>$token,
            ])->header('jwt_token', $token); 
    }

   
}
