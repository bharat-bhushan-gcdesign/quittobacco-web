<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthImprovement;
use Illuminate\Http\Request;
use App\Http\Resources\HealthImprovement as HealthImprovementResource;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;

class HealthImprovementController extends Controller
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

    /** Return HealthImprovement request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'health improvements Retrieved Successfully',
            'data'=>$user->healthImprovement !=null ? new HealthImprovementResource($user->healthImprovement) : "",
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
     * @param  \App\Models\HealthImprovement  $health_improvement
     * @return \Illuminate\Http\Response
     */
    public function show(HealthImprovement $health_improvement)
    {
        //
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\HealthImprovement  $health_improvement
     * @return \Illuminate\Http\Response
     */
    public function edit(HealthImprovement $health_improvement)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HealthImprovement  $health_improvement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HealthImprovement $health_improvement)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\HealthImprovement  $health_improvement
     * @return \Illuminate\Http\Response
     */
    public function destroy(HealthImprovement $health_improvement)
    {
        //
    }
}
