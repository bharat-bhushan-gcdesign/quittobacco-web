<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\Saving as SavingResource;

use App\Models\WishList;
use Illuminate\Http\Request;
use App\Http\Resources\WishListCollection;
use App\Http\Resources\WishList as WishListResource;
use Validator;
use Illuminate\Support\Str;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use DB;
class WishListController extends Controller
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
            'message'=>'WishLists Retrieved Successfully',
            'data'=>['achieved_count'=>$user->wishLists->where('completed_status',1)->count(),
                'money'=> [
                'per_day'=> $user->user_information->country->currency_symbol.$user->user_information->money_spent,
                'per_week'=> $user->user_information->country->currency_symbol.$user->user_information->money_spent * 7,
                'per_month'=> $user->user_information->country->currency_symbol.$user->user_information->money_spent * 30,
                'per_year'=> $user->user_information->country->currency_symbol.$user->user_information->money_spent * 364,
                'total'=> $user->user_information->country->currency_symbol.Auth::user()->cravings->where('carving_status',0)->count()*Auth::user()->user_information->money_spent,
            ],
                "wish_lists" => new WishListCollection($user->wishLists)
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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'notes' => 'required',
            
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

        $wishList=DB::transaction(function() use ($request,$user){


            $wishList=WishList::firstOrCreate([
                'name'=>ucwords(strtolower($request->name)),
                'notes'=>ucwords(strtolower($request->notes)),
                'price'=>$request->price,
                'user_id'=>$user->id,
                'status'=>1
            ]);

            if($request->image!=null){

                @list($type, $file_data) = explode(';', $request->input('image'));

                @list(, $file_data) = explode(',', $file_data); 

                $imageName   = $user->code.$user->id.Str::random(5).'.'.'png'; 

                file_put_contents(base_path() . '/public/uploads/files/'. $imageName, base64_decode($file_data));

                $wishList->file()->save(new \App\Models\File([
                    'name' =>$imageName, 
                ]));
            }

            return $wishList;
        });

    

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return WishList request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'WishList Created Successfully',
            'data'=>new WishListResource($wishList),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function show(WishList $wishList)
    {
         return response()->json([
            'status' => 200,
            'message'=>'WishList Retrieved Successfully',
            'data'=>new WishListResource($wishList),
        ]); 


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function edit(WishList $wishList)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WishList $wishList)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'notes' => 'required',
            //  'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);


    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

        $wishList=DB::transaction(function() use ($request,$user,$wishList){


            $wishList->update([
                'name'=>$request->name!=null ? ucwords(strtolower($request->name)) : $wishList->name,
                'notes'=>$request->notes!=null ? ucwords(strtolower($request->notes)) : $wishList->notes,
                'price'=>$request->price!=null ? $request->price : $wishList->price,
            ]);


            $image = $request->file('image');
            $name="";

            if($request->image!=null){

                @list($type, $file_data) = explode(';', $request->input('image'));

                @list(, $file_data) = explode(',', $file_data); 

                $imageName   = $user->code.$user->id.Str::random(5).'.'.'png'; 

                file_put_contents(base_path() . '/public/uploads/files/'. $imageName, base64_decode($file_data));

                unlink(public_path('uploads/files/' . $wishList->file->name));

                $wishList->file->update([
                    'name' =>$imageName, 
                ]);

            }
            

            return $wishList;
        });
       
        
   

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return WishList request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'WishList Updated Successfully',
            'data'=>new WishListResource($wishList),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function destroy(WishList $wishList)
    {
        $wishList->delete();

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return WishList request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'WishList Deleted Successfully',
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }
    
}
