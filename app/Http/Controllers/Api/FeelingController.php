<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feeling;
use Illuminate\Http\Request;
use App\Http\Resources\FeelingCollection;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;

class FeelingController extends Controller
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

    /** Return Feeling request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Feelings Retrieved Successfully',
            'data'=>new FeelingCollection(Feeling::Status()->get()),
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
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function show(Feeling $feeling)
    {
        //
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function edit(Feeling $feeling)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feeling $feeling)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feeling $feeling)
    {
        //
    }
}
