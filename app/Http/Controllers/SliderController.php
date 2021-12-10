<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\Schedule;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sliders.index')->with('sliders',Slider::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sliders.create')->with('schedules',Schedule::Status()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slider=Slider::firstOrCreate([
            'title'=>ucwords(strtolower($request->title)),
            'type'=>ucwords(strtolower($request->type)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        if($request->type==1 && is_file($request->image_content))
            $slider->content =(new FileController)->store($request->image_content);
        else
            $slider->content =ucwords(strtolower($request->text_content));

        $slider->save();

        return redirect()->route('sliders.index')
                ->with('success_message','Slider added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        return view('sliders.show')->with('slider',$slider);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('sliders.create')->with('slider',$slider)->with('schedules',Schedule::Status()->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {

        if($slider->type==1 && is_file($slider->content))
            unlink(public_path('uploads/files/' . $slider->content));

        if($request->type==1 && is_file($request->image_content))
            $content =(new FileController)->store($request->image_content);
        else
            $content =ucwords(strtolower($request->text_content));

        $slider->update([
            'title'=>ucwords(strtolower($request->title)),
            'type'=>ucwords(strtolower($request->type)),
            'content'=>$content,
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

       
       
        return redirect()->route('sliders.index')
                ->with('success_message','Slider updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('sliders.index')
                ->with('success_message','Slider deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $slider=Slider::where('id',$request->id)->first();
        if(is_object($slider)){
            $slider->update([
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
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Slider::where([
                'title'=>$request->title,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
