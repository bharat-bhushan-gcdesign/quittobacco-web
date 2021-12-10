<?php

namespace App\Http\Controllers;

use App\Models\CarvingVideo;

use App\Models\File;
//use App\Models\Tobacco;

use Illuminate\Http\Request;

class CarvingVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $eventpayment = CarvingVideo::get(); 
        return view('carving_videos.index',['carving_videos'=>$eventpayment]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('carving_videos.create')->with('tobaccos',Tobacco::all());
    // }
     public function create()
    {
           $pid=""; 
            return view('carving_videos.create',['pid'=>$pid]);
           
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->video!=""){
            $names = date('His').$request->video->getClientOriginalName();
            $request->video->move(base_path() . '/public/uploads/video', $names);
        }

        if($request->thumbnail!=""){
             $image = date('His').$request->thumbnail->getClientOriginalName();
            $request->thumbnail->move(base_path() . '/public/uploads/files', $image);
        }
        $carving_video=CarvingVideo::firstOrCreate([
            'name'=>ucwords(strtolower($request->name)),
            'videos'=>$names,
            'thumbnail'=>$image,
            'status'=>$request->status

    ]);
        return redirect()->route('carving_videos.index')
                ->with('success_message','Category Video added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarvingVideo  $carving_video
     * @return \Illuminate\Http\Response
     */
    public function show(CarvingVideo $carving_video)
    {
        return view('carving_videos.show')->with('carving_video',$carving_video);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarvingVideo  $carving_video
     * @return \Illuminate\Http\Response
     */
    public function edit(CarvingVideo $carving_video)
    {

        return view('carving_videos.create')->with('carving_video',$carving_video);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarvingVideo  $carving_video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarvingVideo $carving_video)
    {

         if($request->video!=""){
            $name = date('His').$request->video->getClientOriginalName();
            $request->video->move(base_path() . '/public/uploads/video', $name);
        }
        else
        {
            $name=$carving_video->videos;
        }

      
        if($request->thumbnail!=""){

            if(is_file($carving_video->thumbnail))
            unlink(public_path('/uploads/files/' . $carving_video->thumbnail));

            $image =  date('His').$request->thumbnail->getClientOriginalName();
            $request->thumbnail->move(base_path() . '/public/uploads/files', $image);


        }
        else
        {
            $image=$carving_video->thumbnail;
        }
        $carving_video->update([
            'name'=>ucwords(strtolower($request->name)),
            'videos'=>$name,
            'thumbnail'=>$image,
            'status'=>$request->status
        ]);
       
        return redirect()->route('carving_videos.index')
                ->with('success_message','Category Video updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarvingVideo  $carving_video
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarvingVideo $carving_video)
    {
        $carving_video->delete();
        return redirect()->route('carving_videos.index')
                ->with('success_message','Category Video deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\CarvingVideo  $carving_video
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $carving_video=CarvingVideo::where('id',$request->id)->first();
        if(is_object($carving_video)){
            $carving_video->update([
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
     * @param  \App\CarvingVideo  $carving_video
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return CarvingVideo::where([
                'name'=>$request->name,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
     public function deleteimage(){
        $result = 1;
        return  json_encode($result);
    }
}
