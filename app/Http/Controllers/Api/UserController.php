<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserRequest;
use App\Http\Requests\AuthRequest;

use App\Http\Controllers\Api\FileController;
use App\Http\Traits\UserTrait;
use JWTAuth;
use JWTFactory;
use Mail;
use Auth;
use DB;
use App\Models\Device;

/** by Jemima on 11-08-2020 */

class UserController extends Controller
{
    use UserTrait;

    

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
    public function store(UserRequest $request)
    {
        $user=DB::transaction(function() use ($request){

        /** Create new User */
            $user=User::firstOrCreate([
                'email'=>$request->email,
                'mobile'=>$request->mobile,
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


        /** Generate otp and update to the user */
            $this->generateOTP($user);

        
            // $notification=Notification::firstOrCreate([
            //     'email'=>$request->email,
            // ],[
            //     'name'=>$request->name,
            //     'social_media_id'=>$request->social_media_id,
            //     'type'=>$request->type !=null ?  $request->type : 1,
            //     'password'=>$request->input('password') !=null ? bcrypt($request->input('password')) : "",
            //     'fcm_token'=>$request->fcm_token,
            //     'role'=>2,
            //     'status'=>1
            // ]);
        
            return $user;
        });
        // $auth_request=new AuthRequest;
        // $auth_request->email_or_phone=$request->mobile;
        // $auth_request->password=$request->password;
        // $auth_request->social_media_id=$request->social_media_id;
        // $auth_request->type=$request->type;

        // return (new AuthController)->login($auth_request);


    /** Generate token for Auth User */
        $token=JWTAuth::fromUser($user);

        // if(!isset($request->security_question))
         /** Return Registerd User data with token */
            return response()->json([
                'status' => 200,
                'message' => 'User Registered sucessfully.',
                'data' => new UserResource($user),
                'jwt_token'=> $token,
            ])->header('Authorization', 'Bearer '.$token);


    /** Return Registerd User data with token */
        // return response()->json([
        //     'status' => 200,
        //     'message' => 'User Registered sucessfully.',
        //     'data' => new UserResource($user),
        //     'jwtToken'=> $token,
        // ])->header('Authorization', 'Bearer '.$token);
    }
  
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $user)
    {

    /** Get Auth User **/
        $user=Auth::User();

    /** Chech Auth User Account **/
        if($user->status!=1)
            return response()->json([
                'status' => $this->internalServerError, 
                'message' => 'Your Account was Deleted or Inactive'
            ]);

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user); 

    /** Return Auth User data with token */
        return response()->json([
            'status' => $this->success,
            'data' => new UserResource($user),
            'message' => 'User Retrieved successfully',
            'jwtToken'=>$token
        ])->header('jwtToken',JWTAuth::fromUser($user)); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {

    /** Get Auth User **/
        $user =User::where('id',Auth::User()->id)->first();

    /** Chech Auth User Account **/

        if($user->status!=1)
            return response()->json([
                'status' => $this->internalServerError, 
                'message' => 'Your Account was Deleted or Inactive'
            ]);

    /** Update Auth User data - email, mobile, name, fcm_token **/

        $user->update([
            'email'=>$request->email != "" ? $request->email : $user->email,
            'mobile'=>$request->mobile != "" ? $request->mobile : $user->mobile,
            'name'=>$request->name != "" ? $request->name : $user->name,
            'fcm_token'=>$request->fcm_token != "" ? $request->fcm_token : $user->fcm_token,
        ]);
           
    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);

    /** Return Auth User updated data with token */
        return response()->json([
            'status' => $this->created,
            'message' => 'User Updated sucessfully.',
            'data' => new UserResource($user),
            'jwtToken'=>JWTAuth::fromUser($user)
        ])->header('Authorization', 'Bearer '.$token);
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function updatePassword(UserRequest $request){

    /** Get User by secret code **/

        $user=User::where('id',$request->id)->first();

    /** Update User's password **/

        if($user->security_question!=$request->security_question)
            /** Return password updates */
            return response()->json([
                'status' => 400, 
                'message' => 'Please select registered Date of Birth'
            ], $this->success); 

        $user->update([
            'password'=> bcrypt($request->new_password)
        ]);


    /** Return password updates */
        return response()->json([
            'status' => $this->success, 
            'message' => 'Password Updated Successfully'
        ], $this->success); 
    }
     /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function verifyOtp(UserRequest $request){

    /** Get User by secret id **/
        $user=User::where('id',$request->id)->first();

    /** Verify requested otp with user's otp **/
        if($request->otp != $user->otp)
            return response()->json([
                'status' => $this->badRequest, 
                'message' => 'Invalid Otp'

            ], $this->success); 

    /** Update user's otp to null **/
        $user->update([
            'otp'=> ""
        ]);
        if($request->password != ""){
         	$auth_request=new AuthRequest;
        	$auth_request->email_or_phone=$user->mobile;
        	$auth_request->password=$request->password;
        	return (new AuthController)->login($auth_request);
       	}
    /** Return with Otp verification */
        return response()->json([
            'status' => $this->success, 
            'message' => 'Otp Verified Successfully'
        ], $this->success); 
    } 

    /**
     * Resend Otp.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resendOtp(UserRequest $request)
    {

    /** Get User by requested mobile number **/
        $user=User::where('mobile',$request->mobile)->first();

    /** Generate otp and update to the user */
        $this->generateOTP($user);

    /** Return with Otp sent and user's secret code */
        return response()->json([
            'status' => $this->success, 
            'message' => 'Otp has been sent to '.$user->mobile,
            'data'=>$user->id,
        ], $this->success);  
    }

    /**
     * forgot password.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(UserRequest $request)
    {

    /** Get User by requested mobile number **/
        $user=User::where('mobile',$request->mobile)->first();

    /** Generate otp and update to the user */
        $this->generateOTP($user);

    /** Return with Otp sent and user's secret code */
        return response()->json([
            'status' => $this->success, 
            'message' => 'Your Account Verified Successfully',
            'data'=>$user->id,
        ], $this->success);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
   
   
}
