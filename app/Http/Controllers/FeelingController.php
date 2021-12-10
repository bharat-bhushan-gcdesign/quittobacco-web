<?php

namespace App\Http\Controllers;

use App\Models\Feeling;
use Illuminate\Http\Request;

class FeelingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('feelings.index')->with('feelings',Feeling::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feelings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feeling=Feeling::firstOrCreate([
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('feelings.index')
                ->with('success_message','Feeling added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function show(Feeling $feeling)
    {
        return view('feelings.show')->with('feeling',$feeling);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function edit(Feeling $feeling)
    {
        return view('feelings.create')->with('feeling',$feeling);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feeling $feeling)
    {
        $feeling->update([
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('feelings.index')
                ->with('success_message','Feeling updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feeling $feeling)
    {
        $feeling->delete();
        return redirect()->route('feelings.index')
                ->with('success_message','Feeling deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $feeling=Feeling::where('id',$request->id)->first();
        if(is_object($feeling)){
            $feeling->update([
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
     * @param  \App\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Feeling::where([
                'name'=>$request->name,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
