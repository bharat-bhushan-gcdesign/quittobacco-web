<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UseReason;
use Illuminate\Http\Request;
use App\Http\Resources\UseReasonCollection;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;

class UseReasonController extends Controller
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

    /** Return UseReason request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Use Reasons Retrieved Successfully',
            'data'=>new UseReasonCollection(UseReason::Status()->get()),
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
     * @param  \App\Models\UseReason  $useReason
     * @return \Illuminate\Http\Response
     */
    public function show(UseReason $useReason)
    {
        //
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\UseReason  $useReason
     * @return \Illuminate\Http\Response
     */
    public function edit(UseReason $useReason)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UseReason  $useReason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UseReason $useReason)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\UseReason  $useReason
     * @return \Illuminate\Http\Response
     */
    public function destroy(UseReason $useReason)
    {
        //
    }
}
