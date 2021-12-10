<?php

namespace App\Http\Controllers;

use App\Models\Splash_message;
use Illuminate\Http\Request;

class SplashMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('splash_messages.index')->with('splash_messages',Splash_message::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('splash_messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $splash_message=Splash_message::firstOrCreate([
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('splash_messages.index')
                ->with('success_message','Splash_message added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Splash_message  $splash_message
     * @return \Illuminate\Http\Response
     */
    public function show(Splash_message $splash_message)
    {
        return view('splash_messages.show')->with('profession',$splash_message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Splash_message  $splash_message
     * @return \Illuminate\Http\Response
     */
    public function edit(Splash_message $splash_message)
    {
        return view('splash_messages.create')->with('profession',$splash_message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Splash_message  $splash_message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Splash_message $splash_message)
    {
        $splash_message->update([
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('splash_messages.index')
                ->with('success_message','Splash_message updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Splash_message  $splash_message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Splash_message $splash_message)
    {
        $splash_message->delete();
        return redirect()->route('splash_messages.index')
                ->with('success_message','Splash_message deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Splash_message  $splash_message
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $splash_message=Splash_message::where('id',$request->id)->first();
        if(is_object($splash_message)){
            $splash_message->update([
                'status'=>$request->status=="false" ? 0 : 1
            ]);
            return "success";
        }
        else
            return "failed";
    } 
      /**
     * Check Exist 
     *
     * @param  \App\Splash_message  $splash_message
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Splash_message::where([
                'name'=>$request->name,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
