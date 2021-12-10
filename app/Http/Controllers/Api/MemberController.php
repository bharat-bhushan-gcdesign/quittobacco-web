<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Resources\MemberCollection;
use App\Http\Resources\Member as MemberResource;
use Validator;
use Illuminate\Support\Str;

use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use Mail;
class MemberController extends Controller
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
            'message'=>'Members Retrieved Successfully',
            'data'=>new MemberCollection($user->members),
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
            'name' => 'required',
            'relationship' => 'required',

        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);


        $member=Member::firstOrCreate([
            'name'=>ucwords(strtolower($request->name)),
            'relationship'=>ucwords(strtolower($request->relationship)),
            'mobile'=>$request->mobile,
            'email'=>$request->email,
            'user_id'=>Auth::User()->id,
            'status'=>1
        ]);

        if($request->image!=null){

                @list($type, $file_data) = explode(';', $request->input('image'));

                @list(, $file_data) = explode(',', $file_data); 

                $imageName = $member->name.$member->user_id.Str::random(5).'.'.'png'; 

                file_put_contents(base_path() . '/public/uploads/files/'. $imageName, base64_decode($file_data));

                $member->file()->save(new \App\Models\File([
                    'name' =>$imageName, 
                ]));
            }

    /** mail process */

       /* if($request->email != null){
                $data = array('name'=>$member->name,'message_data'=>'Your friend and loved one has added you as a supporter to help them quit using tobacco products.');

                Mail::send('mail', $data, function($message) use ($member) {
                    $message->to($member->email)->subject('Support your loved one with quitting tobacco');
                    $message->from(ENV('MAIL_USERNAME'),'WHO');
                });
        };*/
        



    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Member request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Member Created Successfully',
            'data'=>new MemberResource($member),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
             
          /** Get Auth User **/
        $user=Auth::User();

        $token = JWTAuth::fromUser($user); 

    /** Return User Skill data with token */
        return response()->json([
            'status' => $this->success,
            'data' =>new MemberResource($member),
            'message' => 'Member Retrieved successfully',
            'jwtToken'=>$token
        ])->header('jwtToken',JWTAuth::fromUser($user)); 

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'relationship' => 'required',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        $member->update([
            'name'=>$request->name!="" ? ucwords(strtolower($request->name)) : $member->name,
            'relationship'=>$request->relationship!="" ?  ucwords(strtolower($request->relationship)) : $member->relationship,
            'mobile'=>$request->mobile!="" ? $request->mobile : $member->mobile,
        ]);


        if($request->image!=null){

            @list($type, $file_data) = explode(';', $request->input('image'));

            @list(, $file_data) = explode(',', $file_data); 

            $imageName   = $member->name.$member->user_id.Str::random(5).'.'.'png'; 

            file_put_contents(base_path() . '/public/uploads/files/'. $imageName, base64_decode($file_data));

            if($member->file!=null)
                $member->file->update([
                    'name' =>$imageName, 
                ]);
            else
                $member->file()->save(new \App\Models\File([
                    'name' =>$imageName, 
                ]));
        }
       
        
    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Member request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Supporter Updated Successfully',
            'data'=>new MemberResource($member),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Member request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Member Deleted Successfully',
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }
    
}
