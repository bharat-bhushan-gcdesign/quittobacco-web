<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuitBenefit;
use Illuminate\Http\Request;
use App\Http\Resources\QuitBenefitCollection;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;

class QuitBenefitController extends Controller
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

    /** Return QuitBenefit request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Quit Benefits Retrieved Successfully',
            'data'=>new QuitBenefitCollection(QuitBenefit::Status()->get()),
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
     * @param  \App\Models\QuitBenefit  $quit_benefit
     * @return \Illuminate\Http\Response
     */
    public function show(QuitBenefit $quit_benefit)
    {
        //
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\QuitBenefit  $quit_benefit
     * @return \Illuminate\Http\Response
     */
    public function edit(QuitBenefit $quit_benefit)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuitBenefit  $quit_benefit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuitBenefit $quit_benefit)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\QuitBenefit  $quit_benefit
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuitBenefit $quit_benefit)
    {
        //
    }
}
