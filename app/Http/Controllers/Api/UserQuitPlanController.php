<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\UserQuitPlan;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Resources\UserQuitPlanCollection;
use App\Http\Resources\UserQuitPlan as UserQuitPlanResource;
use Validator;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use DB;
use Mail;

use Illuminate\Support\Str;


class UserQuitPlanController extends Controller
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


        $user_quit_plans=array();
        $i = 0;
        // return $user->user_quit_plans[0]->steps;
        foreach ($user->user_quit_plans as $user_quit_plan) {
            // if($user_quit_plan->steps!="")
                $user_quit_plans['environment_challenges'][$i]['steps']=$user_quit_plan->steps;
            // if($user_quit_plan->challenge!="")
                $user_quit_plans['personal_challenge'][$i]['challenge']=$user_quit_plan->challenge;
            // if($user_quit_plan->copying_strategy!="")
                $user_quit_plans['personal_challenge'][$i]['copying_strategy']=$user_quit_plan->copying_strategy;

                // $user_quit_plans[$i]['status']=$craving->carving_status;
                $i++;

            // else
                // array_push($used_days,$craving->created_at->format('d-m-Y'));
        }

    /** Return Profession request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'UserQuitPlans Retrieved Successfully',
            'data'=>[
                'quit_date'=>$user->user_information->quit_date,
                'user_quit_plans'=>$user_quit_plans,
            ],
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

        // \Log::info($request);

        // $validator = Validator::make($request->all(), [
        //     'challenge' => 'required',
        //     'copying_strategy' => 'required',
        //     'steps' => 'required',
        // ]);
        // if ($validator->fails()) 
        //     return response()->json(['error_message'=>$validator->errors()], 400);

        /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

            $user->user_information->quit_date_time=$request->quit_date_time;
            $user->user_information->quit_timestamp=$request->quit_timestamp;
            $user->user_information->quit_date=$request->quit_date;
            $user->user_information->save();


            // update([
            //     'quit_date_time'=>$request->quit_date_time,
            //     'quit_timestamp'=>$request->quit_timestamp,
            //     'quit_date'=>$request->quit_date
            // ]);

        //$user_quit_plan=DB::transaction(function() use ($request,$user){

            


            if($request->link_members!=null)

                foreach ($request->link_members as $link_member) {
                    

                    $imageName = '';
                    
                    $member=Member::firstOrCreate([
                        'name'=>ucwords(strtolower($link_member['name'])),
                        'relationship'=>ucwords(strtolower($link_member['relation'])),
                        'email'=>ucwords(strtolower($link_member['email'])),
                        'user_id'=>$user->id,
                        'status'=>1
                    ]);
                    if(isset($link_member['image']) && $link_member['image']!=null){
                        @list($type, $file_data) = explode(';', $link_member['image']);
                        @list(, $file_data) = explode(',', $file_data); 
                        $imageName = $member->name.$member->user_id.Str::random(5).'.'.'png'; 
                        file_put_contents(base_path() . '/public/uploads/files/'. $imageName, base64_decode($file_data));
                        $member->file()->save(new \App\Models\File([
                            'name' =>$imageName, 
                        ]));
                    }
                    /** mail process */
                    /*if(isset($link_member['email']) && $link_member['email']!=null){
                            $data = array('name'=>$link_member['name'],'message_data'=>'Your friend and loved one has added you as a supporter to help them quit using tobacco products.');

                            Mail::send('mail', $data, function($message) use ($link_member) {
                                $message->to($link_member['email'])->subject('Support your loved one with quitting tobacco');
                                $message->from(ENV('MAIL_USERNAME'),'WHO');
                            });
                    };*/
                }

            if($request->personal_challenges!=null)
                foreach ($request->personal_challenges as $personal_challenge) {
                    UserQuitPlan::firstOrCreate([
                        'challenge'=>ucwords(strtolower($personal_challenge['challenge'])),
                        'copying_strategy'=>ucwords(strtolower($personal_challenge['copying_strategy'])),
                        'user_id'=>$user->id,
                        'status'=>1
                    ]);
                }
                 
            if($request->env_challenges!=null)
                foreach ($request->env_challenges as $env_challenge) {
                    UserQuitPlan::firstOrCreate([
                        'steps'=>ucwords(strtolower($env_challenge['name'])),
                        'user_id'=>$user->id,
                        'status'=>1
                    ]);
                }

            
        // });
                if($request->qp==1)
                    $message =  'Quit plan has been Updated Successfully';
                elseif($request->qp==0)
                     $message =  'User Information Updated Successfully';
                elseif($request->qp==2)
                     $message =  'Supporter Added Successfully';

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return UserQuitPlan request data with token */
        return response()->json([
            'status' => 200,
            'message'=>$message,
            // 'data'=>new UserQuitPlanResource($user_quit_plan),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserQuitPlan  $user_quit_plan
     * @return \Illuminate\Http\Response
     */
    public function show(UserQuitPlan $user_quit_plan)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserQuitPlan  $user_quit_plan
     * @return \Illuminate\Http\Response
     */
    public function edit(UserQuitPlan $user_quit_plan)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserQuitPlan  $user_quit_plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserQuitPlan $user_quit_plan)
    {

    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserQuitPlan  $user_quit_plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserQuitPlan $user_quit_plan)
    {
        $user_quit_plan->delete();

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return UserQuitPlan request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Deleted Successfully',
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }
    
}
