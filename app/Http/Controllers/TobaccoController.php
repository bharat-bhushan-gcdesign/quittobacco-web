<?php

namespace App\Http\Controllers;

use App\Models\Tobacco;
use Illuminate\Http\Request;

class TobaccoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tobaccos.index')->with('tobaccos',Tobacco::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tobaccos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tobacco=Tobacco::firstOrCreate([
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('tobaccos.index')
                ->with('success_message','Tobacco added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tobacco  $tobacco
     * @return \Illuminate\Http\Response
     */
    public function show(Tobacco $tobacco)
    {
        return view('tobaccos.show')->with('tobacco',$tobacco);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tobacco  $tobacco
     * @return \Illuminate\Http\Response
     */
    public function edit(Tobacco $tobacco)
    {
        return view('tobaccos.create')->with('tobacco',$tobacco);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tobacco  $tobacco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tobacco $tobacco)
    {
        $tobacco->update([
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('tobaccos.index')
                ->with('success_message','Tobacco updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tobacco  $tobacco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tobacco $tobacco)
    {
        $tobacco->delete();
        return redirect()->route('tobaccos.index')
                ->with('success_message','Tobacco deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Tobacco  $tobacco
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $tobacco=Tobacco::where('id',$request->id)->first();
        if(is_object($tobacco)){
            $tobacco->update([
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
     * @param  \App\Tobacco  $tobacco
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Tobacco::where([
                'name'=>$request->name,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
