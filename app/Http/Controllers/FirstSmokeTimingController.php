<?php

namespace App\Http\Controllers;

use App\Models\FirstSmokeTiming;
use Illuminate\Http\Request;

class FirstSmokeTimingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('first_smoke_timings.index')->with('first_smoke_timings',FirstSmokeTiming::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('first_smoke_timings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $first_smoke_timing=FirstSmokeTiming::firstOrCreate([
            'occurence'=>ucwords(strtolower($request->occurence)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('first_smoke_timings.index')
                ->with('success_message','First SmokeTiming added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FirstSmokeTiming  $first_smoke_timing
     * @return \Illuminate\Http\Response
     */
    public function show(FirstSmokeTiming $first_smoke_timing)
    {
        return view('first_smoke_timings.show')->with('first_smoke_timing',$first_smoke_timing);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FirstSmokeTiming  $first_smoke_timing
     * @return \Illuminate\Http\Response
     */
    public function edit(FirstSmokeTiming $first_smoke_timing)
    {
        return view('first_smoke_timings.create')->with('first_smoke_timing',$first_smoke_timing);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FirstSmokeTiming  $first_smoke_timing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FirstSmokeTiming $first_smoke_timing)
    {
        $first_smoke_timing->update([
            'occurence'=>ucwords(strtolower($request->occurence)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('first_smoke_timings.index')
                ->with('success_message','First SmokeTiming updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FirstSmokeTiming  $first_smoke_timing
     * @return \Illuminate\Http\Response
     */
    public function destroy(FirstSmokeTiming $first_smoke_timing)
    {
        $first_smoke_timing->delete();
        return redirect()->route('first_smoke_timings.index')
                ->with('success_message','First SmokeTiming deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\FirstSmokeTiming  $first_smoke_timing
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $first_smoke_timing=FirstSmokeTiming::where('id',$request->id)->first();
        if(is_object($first_smoke_timing)){
            $first_smoke_timing->update([
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
     * @param  \App\FirstSmokeTiming  $first_smoke_timing
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return FirstSmokeTiming::where([
                'occurence'=>$request->occurence,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
