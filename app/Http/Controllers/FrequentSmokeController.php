<?php

namespace App\Http\Controllers;

use App\Models\FrequentSmoke;
use Illuminate\Http\Request;

class FrequentSmokeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frequent_smokes.index')->with('frequent_smokes',FrequentSmoke::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frequent_smokes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $frequent_smoke=FrequentSmoke::firstOrCreate([
            'instance'=>ucwords(strtolower($request->instance)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('frequent_smokes.index')
                ->with('success_message','Frequent Smoke added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FrequentSmoke  $frequent_smoke
     * @return \Illuminate\Http\Response
     */
    public function show(FrequentSmoke $frequent_smoke)
    {
        return view('frequent_smokes.show')->with('frequent_smoke',$frequent_smoke);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FrequentSmoke  $frequent_smoke
     * @return \Illuminate\Http\Response
     */
    public function edit(FrequentSmoke $frequent_smoke)
    {
        return view('frequent_smokes.create')->with('frequent_smoke',$frequent_smoke);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FrequentSmoke  $frequent_smoke
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FrequentSmoke $frequent_smoke)
    {
        $frequent_smoke->update([
            'instance'=>ucwords(strtolower($request->instance)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('frequent_smokes.index')
                ->with('success_message','Frequent Smoke updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FrequentSmoke  $frequent_smoke
     * @return \Illuminate\Http\Response
     */
    public function destroy(FrequentSmoke $frequent_smoke)
    {
        $frequent_smoke->delete();
        return redirect()->route('frequent_smokes.index')
                ->with('success_message','Frequent Smoke deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\FrequentSmoke  $frequent_smoke
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $frequent_smoke=FrequentSmoke::where('id',$request->id)->first();
        if(is_object($frequent_smoke)){
            $frequent_smoke->update([
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
     * @param  \App\FrequentSmoke  $frequent_smoke
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return FrequentSmoke::where([
                'instance'=>$request->instance,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
