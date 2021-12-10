<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TobaccoProduct;
use Illuminate\Http\Request;
use App\Http\Resources\TobaccoProductCollection;
use App\User;
use Validator;
use Auth;
use JWTFactory;
use JWTAuth;

class TobaccoProductController extends Controller
{
    /**
     * Display a listing of the source.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

    /** Get user by secret code */

    
        $validator = Validator::make($request->all(), [
            'tobacco_id'=> 'required|exists:tobaccos,id',
        ]);

        if($validator->fails()) 
            return response()->json(['error_message'=>$validator->errors()], 400);

        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return TobaccoProduct request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Tobaccos Products Retrieved Successfully',
            'data'=>new TobaccoProductCollection ($request->tobacco_id == 4 ? TobaccoProduct::Status()->get(): TobaccoProduct::whereIn('tobacco_id',[$request->tobacco_id,4])->Status()->get()),
            'jwt_token'=>$token,
        ])->header('jwt_token', $token); 
    }

    /**
     * Show the form for creating a new source.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified source.
     *
     * @param  \App\Models\Tobacco  $tobacco
     * @return \Illuminate\Http\Response
     */
    public function show(Tobacco $tobacco)
    {
        //
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\Tobacco  $tobacco
     * @return \Illuminate\Http\Response
     */
    public function edit(Tobacco $tobacco)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tobacco  $tobacco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tobacco $tobacco)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\Tobacco  $tobacco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tobacco $tobacco)
    {
        //
    }
}
