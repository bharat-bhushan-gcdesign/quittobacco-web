<?php

namespace App\Http\Controllers\Api;

use App\Models\Saving;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use App\Http\Resources\Saving as SavingResource;

class SavingController extends Controller
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

        /** Return Saving request data with token */
            return response()->json([
                'status' => 200,
                'message'=>'Savings Retrieved Successfully',
                'data'=> 
                ['per_day'=> $user->user_information->country->currency_symbol.$user->user_information->money_spent,
                'per_week'=> $user->user_information->country->currency_symbol.$user->user_information->money_spent * 7,
                'per_month'=> $user->user_information->country->currency_symbol.$user->user_information->money_spent * 30,
                'per_year'=> $user->user_information->country->currency_symbol.$user->user_information->money_spent * 364,
                'total'=> $user->user_information->country->currency_symbol.Auth::user()->cravings->where('carving_status',0)->count()*Auth::user()->user_information->money_spent],
            ]); 


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Saving  $saving
     * @return \Illuminate\Http\Response
     */
    public function show(Saving $saving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Saving  $saving
     * @return \Illuminate\Http\Response
     */
    public function edit(Saving $saving)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Saving  $saving
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Saving $saving)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Saving  $saving
     * @return \Illuminate\Http\Response
     */
    public function destroy(Saving $saving)
    {
        //
    }
}
