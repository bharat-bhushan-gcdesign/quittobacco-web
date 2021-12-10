<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FrequentSmoke;
use Illuminate\Http\Request;
use App\Http\Resources\FrequentSmokeCollection;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;

class FrequentSmokeController extends Controller
{
    /**
     * Display a listing of the source.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return FrequentSmoke request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Frequent Smokes Retrieved Successfully',
            'data'=>['Frequent_Smokes'=> new FrequentSmokeCollection(FrequentSmoke::Status()->get()),
             'symbol'=>"₹",
            'currency'=>"INR",],
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
     * @param  \App\Models\FrequentSmoke  $frequentSmoke
     * @return \Illuminate\Http\Response
     */
    public function show(FrequentSmoke $frequentSmoke)
    {
        //
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\FrequentSmoke  $frequentSmoke
     * @return \Illuminate\Http\Response
     */
    public function edit(FrequentSmoke $frequentSmoke)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FrequentSmoke  $frequentSmoke
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FrequentSmoke $frequentSmoke)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\FrequentSmoke  $frequentSmoke
     * @return \Illuminate\Http\Response
     */
    public function destroy(FrequentSmoke $frequentSmoke)
    {
        //
    }
}
