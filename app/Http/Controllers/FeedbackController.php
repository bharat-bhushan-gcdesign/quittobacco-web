<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('feedback.index')->with('feedback',Feedback::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feedback=Feedback::firstOrCreate([
            'title'=>ucwords(strtolower($request->title)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
        if(is_file($request->feedback_file))
            $feedback->file()->save(new \App\Models\File([
                'name' =>(new FileController)->store($request->feedback_file), 
            ]));

        return redirect()->route('feedback.index')
                ->with('success_message','Feedback added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        
        return view('feedback.show')->with('feedback',$feedback);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        return view('feedback.create')->with('feedback',$feedback);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        $feedback->update([
            'title'=>ucwords(strtolower($request->title)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
        $feedback_file = $request->file('feedback_file');
        $name="";
              
        if($request->file('feedback_file')!="")
        {
            if(is_file($feedback_file)){
                if($feedback->file!=null){
                    unlink(public_path('uploads/files/' . $feedback->file->name));
                    $feedback->file->update([
                        'name' =>(new FileController)->store($feedback_file), 
                    ]);
                }else
                $feedback->file()->save(new  \App\Models\File([
                    'name' =>(new FileController)->store($feedback_file), 
                ]));
            }
        }
        return redirect()->route('feedback.index')
                ->with('success_message','Feedback updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedback.index')
                ->with('success_message','Feedback deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $feedback=Feedback::where('id',$request->id)->first();
        if(is_object($feedback)){
            $feedback->update([
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
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Feedback::where([
                'title'=>$request->title,
                'status'=>1
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
