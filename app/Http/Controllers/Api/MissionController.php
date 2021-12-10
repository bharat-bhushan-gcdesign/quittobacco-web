<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Mission;
use Illuminate\Http\Request;
use App\Http\Resources\MissionCollection;
use App\Http\Resources\Mission as MissionResource;
use Validator;
use Illuminate\Support\Str;

use Carbon\Carbon;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use DB;
class MissionController extends Controller
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
            'message'=>'Plan Retrieved Successfully',
            'data'=>['missions'=>new MissionCollection($user->missions),'quit_date'=>(new Carbon($user->user_information->quit_date))->format('d M Y h:i:s a')],
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
            // 'name' => 'required',
            'notes' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

        $mission=DB::transaction(function() use ($request,$user){


            $mission=Mission::firstOrCreate([
                // 'name'=>ucwords(strtolower($request->name)),
                'notes'=>ucwords(strtolower($request->notes)),
                'user_id'=>$user->id,
                'status'=>1
            ]);

            // if($request->image!=null){

            //     @list($type, $file_data) = explode(';', $request->input('image'));

            //     @list(, $file_data) = explode(',', $file_data); 

            //     $imageName   = $user->code.$user->id.Str::random(5).'.'.'png'; 

            //     file_put_contents(base_path() . '/public/uploads/files/'. $imageName, base64_decode($file_data));

            //     $mission->file()->save(new \App\Models\File([
            //         'name' =>$imageName, 
            //     ]));
            // }

            return $mission;
        });

    

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Mission request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Plan Created Successfully',
            'data'=>new MissionResource($mission),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function show(Mission $mission)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function edit(Mission $mission)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mission $mission)
    {

    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mission $mission)
    {
        $mission->delete();

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Mission request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Plan Deleted Successfully',
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }
    
}
