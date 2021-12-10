<?php

namespace App\Http\Controllers;

use App\Models\QuitReason;
use Illuminate\Http\Request;

class QuitReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quit_reasons.index')->with('quit_reasons',QuitReason::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quit_reasons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quit_reason=QuitReason::firstOrCreate([
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('quit_reasons.index')
                ->with('success_message','Quit Reason added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuitReason  $quit_reason
     * @return \Illuminate\Http\Response
     */
    public function show(QuitReason $quit_reason)
    {
        return view('quit_reasons.show')->with('quit_reason',$quit_reason);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuitReason  $quit_reason
     * @return \Illuminate\Http\Response
     */
    public function edit(QuitReason $quit_reason)
    {
        return view('quit_reasons.create')->with('quit_reason',$quit_reason);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuitReason  $quit_reason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuitReason $quit_reason)
    {
        $quit_reason->update([
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('quit_reasons.index')
                ->with('success_message','Quit Reason updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuitReason  $quit_reason
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuitReason $quit_reason)
    {
        $quit_reason->delete();
        return redirect()->route('quit_reasons.index')
                ->with('success_message','Quit Reason deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\QuitReason  $quit_reason
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $quit_reason=QuitReason::where('id',$request->id)->first();
        if(is_object($quit_reason)){
            $quit_reason->update([
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
     * @param  \App\QuitReason  $quit_reason
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return QuitReason::where([
                'name'=>$request->name,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
