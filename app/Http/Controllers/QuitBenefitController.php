<?php

namespace App\Http\Controllers;

use App\Models\QuitBenefit;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\File;
use Validator;

class QuitBenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quit_benefits.index')->with('quit_benefits',QuitBenefit::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quit_benefits.create')->with('schedules',Schedule::Status()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'quit_benefit_file' => 'required'
        ]);
        if ($validator->fails()) 
            return redirect()->route('quit_benefits.index')
                ->with('error_message',$validator->errors());
        
        
        $quit_benefit=QuitBenefit::firstOrCreate([
            'title'=>ucwords(strtolower($request->title)),
            'description'=>$request->description,
            'status'=>$request->status
        ]);

        if(is_file($request->quit_benefit_file))
            $quit_benefit->file()->save(new File([
                'name' =>(new FileController)->store($request->quit_benefit_file), 
            ]));

        return redirect()->route('quit_benefits.index')
                ->with('success_message','QuitBenefit added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuitBenefit  $quit_benefit
     * @return \Illuminate\Http\Response
     */
    public function show(QuitBenefit $quit_benefit)
    {
        return view('quit_benefits.show')->with('quit_benefit',$quit_benefit);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuitBenefit  $quit_benefit
     * @return \Illuminate\Http\Response
     */
    public function edit(QuitBenefit $quit_benefit)
    {
        return view('quit_benefits.create')->with('quit_benefit',$quit_benefit)->with('schedules',Schedule::Status()->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuitBenefit  $quit_benefit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuitBenefit $quit_benefit)
    {

        $validator = Validator::make($request->all(), [
            'quit_benefit_file' => 'file|mimes:jpg,bmp,png'
        ]);
        if ($validator->fails()) 
            return redirect()->back()
                ->with('errors',$validator->errors());


        if($request->type==1 && is_file($request->image_content))
            $content =(new FileController)->store($request->image_content);

        $quit_benefit->update([
            'title'=>ucwords(strtolower($request->title)),
            'type'=>ucwords(strtolower($request->type)),
            'description'=>$request->description,
            'status'=>$request->status
        ]);

        if(is_file($request->quit_benefit_file) && $quit_benefit->file!=null){
            unlink(public_path('uploads/files/' . $quit_benefit->file->name));

            $quit_benefit->file->update([
                'name' =>(new FileController)->store($request->quit_benefit_file), 
            ]);
        }
            
       
       
        return redirect()->back()
                ->with('success_message','QuitBenefit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuitBenefit  $quit_benefit
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuitBenefit $quit_benefit)
    {
        $quit_benefit->delete();
        return redirect()->route('quit_benefits.index')
                ->with('success_message','QuitBenefit deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\QuitBenefit  $quit_benefit
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $quit_benefit=QuitBenefit::where('id',$request->id)->first();
        if(is_object($quit_benefit)){
            $quit_benefit->update([
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
     * @param  \App\QuitBenefit  $quit_benefit
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return QuitBenefit::where([
                'title'=>$request->title,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
