<?php

namespace App\Http\Controllers;

use App\Models\WithWhom;
use Illuminate\Http\Request;

class WithWhomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('with_whoms.index')->with('with_whoms',WithWhom::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('with_whoms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $with_whom=WithWhom::firstOrCreate([
            'relation'=>ucwords(strtolower($request->relation)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('with_whoms.index')
                ->with('success_message','WithWhom added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WithWhom  $with_whom
     * @return \Illuminate\Http\Response
     */
    public function show(WithWhom $with_whom)
    {
        return view('with_whoms.show')->with('with_whom',$with_whom);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WithWhom  $with_whom
     * @return \Illuminate\Http\Response
     */
    public function edit(WithWhom $with_whom)
    {
        return view('with_whoms.create')->with('with_whom',$with_whom);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WithWhom  $with_whom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WithWhom $with_whom)
    {
        $with_whom->update([
            'relation'=>ucwords(strtolower($request->relation)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('with_whoms.index')
                ->with('success_message','WithWhom updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WithWhom  $with_whom
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithWhom $with_whom)
    {
        $with_whom->delete();
        return redirect()->route('with_whoms.index')
                ->with('success_message','WithWhom deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\WithWhom  $with_whom
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $with_whom=WithWhom::where('id',$request->id)->first();
        if(is_object($with_whom)){
            $with_whom->update([
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
     * @param  \App\WithWhom  $with_whom
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return WithWhom::where([
                'relation'=>$request->relation,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
