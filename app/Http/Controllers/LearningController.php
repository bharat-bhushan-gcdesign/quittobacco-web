<?php

namespace App\Http\Controllers;

use App\Models\Learning;

use Illuminate\Http\Request;

class LearningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('learnings.index')->with('learnings',Learning::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('learnings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $learning=Learning::firstOrCreate([
            'title'=>ucwords(strtolower($request->title)),
            'description'=>ucwords(strtolower($request->description)),
            'videos'=>$request->video,
            'status'=>$request->status
        ]);

        return redirect()->route('learnings.index')
                ->with('success_message','Learning added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Learning  $learning
     * @return \Illuminate\Http\Response
     */
    public function show(Learning $learning)
    {
        return view('learnings.show')->with('learning',$learning);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Learning  $learning
     * @return \Illuminate\Http\Response
     */
    public function edit(Learning $learning)
    {
        return view('learnings.create')->with('learning',$learning);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Learning  $learning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Learning $learning)
    {
        $learning->update([
            'title'=>ucwords(strtolower($request->title)),
            'description'=>ucwords(strtolower($request->description)),
            'videos'=>$request->videos,
            'status'=>$request->status
        ]);
        return redirect()->route('learnings.index')
                ->with('success_message','Learning updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Learning  $learning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Learning $learning)
    {
        $learning->delete();
        return redirect()->route('learnings.index')
                ->with('success_message','Learning deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Learning  $learning
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $learning=Learning::where('id',$request->id)->first();
        if(is_object($learning)){
            $learning->update([
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
     * @param  \App\Learning  $learning
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Learning::where([
                'title'=>$request->title,
                'status'=>1
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
