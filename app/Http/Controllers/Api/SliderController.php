<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Resources\SliderCollection;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;

class SliderController extends Controller
{
    /**
     * Display a listing of the source.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'message'=>'sliders Retrieved Successfully',
            'data'=>new SliderCollection(Slider::Status()->get()),
        ]); 
    }

    public function tobaccoinfections()
    {
    /** Get user by secret code */
        // $user =User::where('id',Auth::User()->id)->first();

    /** Generate token for Auth User */
        // $token = JWTAuth::fromUser($user);  

    /** Return Slider request data with token */
        return response()->json([
            'status' => 200,
            'message'=>'Tobaccoinfection Retrieved Successfully',
            'data'=>new SliderCollection(Slider::where('title','Tobacco-infections')->Status()->get()),
            // 'jwt_token'=>$token,
        ]); 
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
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified source.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified source in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified source from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        //
    }
}
