<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Diary;
use App\Models\Craving;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\DiaryCollection;
use App\Http\Resources\Diary as DiaryResource;
use Validator;

use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use DB;
class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // return Auth::User()->diaries;

        /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

        // $used_days=[];
        $days=array();
        $i = 0;
        foreach ($user->cravings as $craving) {
            // if($craving->carving_status==0)
                $days[$i]['date']=$craving->created_at->format('Y-m-d');
                $days[$i]['status']=$craving->carving_status;
                $i++;

            // else
                // array_push($used_days,$craving->created_at->format('d-m-Y'));
        }
    /** Return Profession request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Diarys Retrieved Successfully',
            'data'=>$days,
                // [
                    // 'diary'=>new DiaryCollection($user->diaries),
                    // 'calender'=>[
                        // 'used_days'=>$days,
                        // 'unused_days'=>$unused_days
                    // ]
                // ],
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
            'last_entry' => 'required|numeric',
            'tobacco_desire' => 'required|numeric',
            'craving_count' => 'required|numeric',
            'date' => 'required',
            'notes' => 'required',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

        $diary=DB::transaction(function() use ($request,$user){


            $diary=Diary::updateOrCreate([
            'user_id'=>Auth::User()->id,
            'created_at' => Craving::whereDate('created_at', Carbon::today())->first()->created_at ?? null
            ],[
                'last_entry'=>ucwords(strtolower($request->last_entry)),
                'tobacco_desire'=>ucwords(strtolower($request->tobacco_desire)),
                'craving_count'=>ucwords(strtolower($request->craving_count)),
                'notes'=>ucwords(strtolower($request->notes)),
                'date'=>$request->date,
                'user_id'=>$user->id,
                'status'=>1
            ]);

            return $diary;
        });

    

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Diary request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Diary Created Successfully',
            'data'=>new DiaryResource($diary),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Diary  $diary
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $user =User::where('id',Auth::User()->id)->first();

        $token = JWTAuth::fromUser($user);  

        return response()->json([
            'status' => 200,
            'message'=>'Diary Retrived Successfully',
            'data'=>new DiaryCollection(Diary::where('user_id',Auth::User()->id)->whereDate('date', '=', $request->date)->get()),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 

        // return Auth::User()->diaries;
        // return Diary::where('user_id',Auth::User()->id)->whereDate('date', '=', '2021-07-31')->get();
        // return Auth::User()->diaries->whereDate('created_at', '=', '2021-07-31');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Diary  $diary
     * @return \Illuminate\Http\Response
     */
    public function edit(Diary $diary)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Diary  $diary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diary $diary)
    {

    //     $validator = Validator::make($request->all(), [
    //         'diary_request' => 'required',
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);
    //     if ($validator->fails()) 
    //         return response()->json(['error_message'=>$validator->errors()], 400);


    // /** Get user by secret code */
    //     $user =User::where('id',Auth::User()->id)->first();

    //    $diary=DB::transaction(function() use ($request,$user,$diary){


    //         $diary->update([
    //             'request'=>$request->diary_request!=null ? ucwords(strtolower($request->diary_request)) : $request->diary_request,
    //         ]);


    //         $image = $request->file('image');
    //         $name="";
                  
    //         if($request->file('image')!="")
    //         {
    //             if(is_file($image)){
    //                 if($diary->file!=null){
    //                     unlink(public_path('uploads/files/' . $diary->file->name));
    //                     $diary->file->update([
    //                         'name' =>(new FileController)->store($image), 
    //                     ]); 
    //                 }else
    //                     $diary->file()->save(new  \App\Models\File([
    //                         'name' =>(new FileController)->store($image), 
    //                     ]));
    //             }
    //         }
            

    //         return $diary;
    //     });
       
        
   

    // /** Generate token for Auth User */
    //     $token = JWTAuth::fromUser($user);  

    // /** Return Diary request data with token */
    //     return response()->json([
    //         'status' => 200,
    //         'message'=>'Diary Updated Successfully',
    //         'data'=>new DiaryResource($diary),
    //         'jwt_token'=>$token,
    //     ])->header('jwt_token', $token); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Diary  $diary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diary $diary)
    {
        $diary->delete();

        

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return Diary request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Diary Deleted Successfully',
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }
    
}
