<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FirstSmokeTiming;
use Illuminate\Http\Request;
use App\Http\Resources\FirstSmokeTimingCollection;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;

class FirstSmokeTimingController extends Controller
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

    /** Return FirstSmokeTiming request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'First SmokeTimings Retrieved Successfully',
            'data'=>new FirstSmokeTimingCollection(FirstSmokeTiming::Status()->get()),
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
     * @param  \App\Models\FirstSmokeTiming  $firstSmokeTiming
     * @return \Illuminate\Http\Response
     */
    public function show(FirstSmokeTiming $firstSmokeTiming)
    {
        //
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\FirstSmokeTiming  $firstSmokeTiming
     * @return \Illuminate\Http\Response
     */
    public function edit(FirstSmokeTiming $firstSmokeTiming)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FirstSmokeTiming  $firstSmokeTiming
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FirstSmokeTiming $firstSmokeTiming)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\FirstSmokeTiming  $firstSmokeTiming
     * @return \Illuminate\Http\Response
     */
    public function destroy(FirstSmokeTiming $firstSmokeTiming)
    {
        //
    }
}
