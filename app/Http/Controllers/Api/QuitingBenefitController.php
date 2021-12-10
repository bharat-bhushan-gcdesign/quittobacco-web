<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuitingBenefit;
use Illuminate\Http\Request;
use App\Http\Resources\QuitingBenefitCollection;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;

class QuitingBenefitController extends Controller
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

    /** Return QuitingBenefit request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Quiting Benefits Retrieved Successfully',
            'data'=>new QuitingBenefitCollection(QuitingBenefit::Status()->get()),
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
     * @param  \App\Models\QuitingBenefit  $quiting_benefit
     * @return \Illuminate\Http\Response
     */
    public function show(QuitingBenefit $quiting_benefit)
    {
        //
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\QuitingBenefit  $quiting_benefit
     * @return \Illuminate\Http\Response
     */
    public function edit(QuitingBenefit $quiting_benefit)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuitingBenefit  $quiting_benefit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuitingBenefit $quiting_benefit)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\QuitingBenefit  $quiting_benefit
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuitingBenefit $quiting_benefit)
    {
        //
    }
}
