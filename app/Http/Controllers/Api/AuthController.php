<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use Auth; 

use App\Http\Requests\AuthRequest;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\UserRequest;

use App\User;
use App\Models\Notification;

use Validator;
use Log;
/** by Jemima on 11-08-2020 */

class AuthController extends Controller
{
 
  /*
  * User login 
  */
    public function login(AuthRequest $request){


    /** Match Credentials **/

        // if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
        //     $credentials['email'] = trim($request->email_or_phone);
        //     $credentials['password']= $request->password;
        // }
        // else {
            // $credentials['mobile']= trim($request->email_or_phone);
            // $credentials['password']= $request->password;
        // }

         $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required',
        ]);
        if ($validator->fails()) 
            return response()->json(['errors'=>$validator->errors()], 400);

        $user = User::where(['mobile'=>$request->email_or_phone])->first();
        $message="User Loggedin Successfully";

        if($user==null){
            $message="User Registered Successfully";                                                                           
            $user=User::firstOrCreate([
                'email'=>$request->email,
                'mobile'=>$request->email_or_phone,
            ],[
                'name'=>$request->name,
                'apple_id'=>$request->apple_id,
                'facebook_id'=>$request->facebook_id,
                'gmail_id'=>$request->gmail_id,
                // 'social_media_id'=>$request->social_media_id,
                
                'type'=>$request->type !=null ?  $request->type : 1,
                'password'=>$request->input('password') !=null ? bcrypt($request->input('password')) : "",
                'fcm_token'=>$request->fcm_token,
                'security_question'=>$request->security_question,
                'role'=>2,
                'status'=>1
            ]);
        }

        $user->update([
            'fcm_token'=>$request->fcm_token
        ]);

        Notification::firstOrCreate([
            'user_id'=>$user->id,
        ],[
            'diary_remainder' =>1, 
            'diary_remainder_time' => "18:30", 
            'mission_remainder' =>1,  
            'mission_remainder_time' =>"20:00", 
            'badge' =>1, 
            'general_alert' => 1,
            'status' =>1
        ]);


        

        $token = Auth::guard('api')->fromUser($user);

        /** Return Profession request data with token */

        return response()->json([
            'status' => 200,
            'message'=>$message,
            'data'=>new UserResource($user),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 

    
    }
    
    /*
    * User logout 
    */
    public function logout(){
        Auth::User()->update([
            'fcm_token'=>''
        ]);
        Auth::guard('api')->logout();

        return response()->json([
            'status' => $this->success,
            'message' => 'logout Successfully'
        ], 200);
    }


    public function validation(Request $request){

        if($request->type==1)
            $validator = Validator::make($request->all(), [
                'apple_id' => 'required',
            ]);
        elseif($request->type==2)
            $validator = Validator::make($request->all(), [
                'facebook_id' => 'required',
            ]);
        elseif($request->type==3)
            $validator = Validator::make($request->all(), [
                'google_id' => 'required',
            ]);
        elseif($request->type==4)
            $validator = Validator::make($request->all(), [
                'instagram_id' => 'required',
            ]);
        else
            $validator = Validator::make($request->all(), [
                'type' => 'required',
            ]);

        if ($validator->fails()) 
            return response()->json(['errors'=>$validator->errors()], 400);
    }

     /**
     * Social Media user login
     *
     * @return \Illuminate\Http\Response
     */
    public function social_media_users(UserRequest $request)
    {
        // $validator=$this->validation($request);
       
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'social_media_id' => 'required',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        if($request->type==3){
            $social_media_type='apple_id';
            $request->apple_id=$request->social_media_id;
        }
        elseif($request->type==1){
            $social_media_type='facebook_id';
            $request->facebook_id=$request->social_media_id;

        }
        elseif($request->type==2){
            $social_media_type='gmail_id';
            $request->gmail_id=$request->social_media_id;

        }
        elseif($request->type==4){
            $social_media_type='instagram_id';
        }
        elseif($request->type==5){
            $social_media_type='linked_in_id';
        }
        else
            return 'invalid type';
            
        $social_media_id=$request->social_media_id;
        $request->mobile=isset($request->mobile) ? $request->mobile : "";
        $request->email=isset($request->email) ? $request->email : "";

        $user=User::where($social_media_type,$social_media_id)->first();



        if($user != null && (($user->email== $request->email && $user->email != "")|| ($user->mobile==$request->mobile && $user->mobile != ""))){
            $token=JWTAuth::fromUser($user);
            /** Return Profession request data with token */
            return response()->json([
                'status' => 200,
                'message'=>'User logined Successfully',
                'data'=>new UserResource($user),
                'jwt_token'=>$token,
            ])->header('jwt_token', $token); 
        }
            
        
        elseif($user!=null && (($user->email!=$request->email && $user->email != "") || ($user->mobile!=$request->mobile && $user->mobile != "")) && $social_media_id!=null)
            return response()->json([
                'status' => 500, 
                'message' => 'This Social Media Id is already Synced with Another Account'
            ]);


            $email_user=$request->email!=null ? User::where('email',$request->email)->where('email','!=',null)->first() : null;
            $mobile_user=$request->mobile!=null ?  User::where('mobile',$request->mobile)->where('mobile','!=',null)->first() : null;
            // return $mobile_user;

    
        /** If email already exists */

            if($email_user!=null){

        /** If email and social media already exists */
                if(User::where('email','!=',null)->where(['email'=>$request->email,$social_media_type=>$social_media_id])->exists()){

                    /** Get user by secret code */
                        $email_user=User::where(['email'=>$request->email,$social_media_type=>$social_media_id])->first();

                }else{
                    if(User::where('email','!=',null)->where(['email'=>$request->email,$social_media_type=>$social_media_id])->exists()){
                        return response()->json([
                            'status' => 500, 
                            'message' => 'This Social Media Id is already synced with Another Account'
                        ]);

                    }else{

                        $email_user->update([
                            $social_media_type=>$social_media_id,
                            'fcm_token'=>$request->fcm_token,
                            'status'=>1
                        ]);
                    }
                }
            }
            elseif($mobile_user!=null){
                if(User::where('mobile','!=',null)->where(['mobile'=>$request->mobile,$social_media_type=>$social_media_id])->exists()){



                    /** Get user by secret code */
                        $mobile_user=User::where(['mobile'=>$request->mobile,$social_media_type=>$social_media_id])->first();

                }else{
                    if(User::where('mobile','!=',null)->where(['mobile'=>$request->mobile,$social_media_type=>$social_media_id])->exists()){
                        return response()->json([
                            'status' => 500, 
                            'message' => 'This Social Media Id is already synced with Another Account'
                        ]);

                    }else{

                        $mobile_user->update([
                            $social_media_type=>$social_media_id,
                            'fcm_token'=>$request->fcm_token,
                            'status'=>1
                        ]);
                    }
                }



            }else{
                if(User::where([$social_media_type=>$social_media_id])->exists()){
                    return response()->json([
                        'status' => 500, 
                        'message' => 'This Social Media Id is already synced with Another Account'
                    ]);

                }else{

                    $validator = Validator::make($request->all(), [
                         
                        'fcm_token' => 'required',   
                        'mobile' => 'nullable',
                        'email' => 'nullable',
                    ]);

                    if ($validator->fails()) 
                        return response()->json(['error_message'=>$validator->errors()], 400);
                    // if($user!=null)
                    //         $this->generateOTP($user);
                        
                        $request->type=1;

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