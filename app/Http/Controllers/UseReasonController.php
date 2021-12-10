<?php

namespace App\Http\Controllers;

use App\Models\UseReason;
use Illuminate\Http\Request;

class UseReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('use_reasons.index')->with('use_reasons',UseReason::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('use_reasons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $use_reason=UseReason::firstOrCreate([
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('use_reasons.index')
                ->with('success_message','UseReason added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UseReason  $use_reason
     * @return \Illuminate\Http\Response
     */
    public function show(UseReason $use_reason)
    {
        return view('use_reasons.show')->with('use_reason',$use_reason);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UseReason  $use_reason
     * @return \Illuminate\Http\Response
     */
    public function edit(UseReason $use_reason)
    {
        return view('use_reasons.create')->with('use_reason',$use_reason);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UseReason  $use_reason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UseReason $use_reason)
    {
        $use_reason->update([
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('use_reasons.index')
                ->with('success_message','UseReason updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UseReason  $use_reason
     * @return \Illuminate\Http\Response
     */
    public function destroy(UseReason $use_reason)
    {
        $use_reason->delete();
        return redirect()->route('use_reasons.index')
                ->with('success_message','UseReason deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\UseReason  $use_reason
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $use_reason=UseReason::where('id',$request->id)->first();
        if(is_object($use_reason)){
            $use_reason->update([
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
     * @param  \App\UseReason  $use_reason
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return UseReason::where([
                'name'=>$request->name,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
