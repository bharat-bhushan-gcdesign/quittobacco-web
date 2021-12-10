<?php

namespace App\Http\Controllers;

use App\Models\Motivation;
use Illuminate\Http\Request;

class MotivationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('motivations.index')->with('motivations',Motivation::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('motivations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $motivation=Motivation::firstOrCreate([
            'user_id'=>1,
            'message'=>$request->message,
            'user_type'=>1,
            'status'=>$request->status
        ]);

        return redirect()->route('motivations.index')
                ->with('success_message','Motivation added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function show(Motivation $motivation)
    {
        return view('motivations.show')->with('motivation',$motivation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function edit(Motivation $motivation)
    {
        return view('motivations.create')->with('motivation',$motivation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motivation $motivation)
    {
        $motivation->update([
            'user_id'=>1,
            'message'=>$request->message,
            'user_type'=>1,
            'status'=>$request->status
        ]);
       
        return redirect()->route('motivations.index')
                ->with('success_message','Motivation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Motivation $motivation)
    {
        $motivation->delete();
        return redirect()->route('motivations.index')
                ->with('success_message','Motivation deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $motivation=Motivation::where('id',$request->id)->first();
        if(is_object($motivation)){
            $motivation->update([
                'status'=>$request->status=="false" ? 0 : 1
            ]);
            return "success";
        }
        else
            return "failed";
    } 

    public function publishupdateStatus(Request $request)
    {
         Motivation::where('publish_status',1)->update([
                'publish_status'=>0
            ]);
        $motivation=Motivation::where('id',$request->id)->first();
        if(is_object($motivation)){
            $motivation->update([
                'publish_status'=>$request->status=="false" ? 0 : 1
            ]);
            return "success";
        }
        else
            return "failed";
    } 
      /**
     * Check Exist 
     *
     * @param  \App\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Motivation::where([
                'name'=>$request->request,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
