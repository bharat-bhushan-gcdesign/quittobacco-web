<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarvingVideo;
use Illuminate\Http\Request;
use App\Http\Resources\CarvingVideoCollection;
use App\User;
use Validator;
use Auth;
use JWTFactory;
use JWTAuth;

class CarvingVideoController extends Controller
{
    /**
     * Display a listing of the source.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

    /** Get user by secret code */
        $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        $token = JWTAuth::fromUser($user);  

    /** Return TobaccoProduct request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Carving Video Retrieved Successfully',
            'data'=>new CarvingVideoCollection(CarvingVideo::Status()->orderBy('id', 'ASC')->get()),
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
