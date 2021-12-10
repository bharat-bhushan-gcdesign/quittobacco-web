<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

use App\Models\File;
//use App\Models\Tobacco;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('galleries.index')->with('galleries',Gallery::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('galleries.create')->with('tobaccos',Tobacco::all());
    // }
     public function create()
    {
           $pid=""; 
            return view('galleries.create',['pid'=>$pid]);
           
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
        $carving_video=Gallery::firstOrCreate([
            'name'=>ucwords(strtolower($request->name)),
            'videos'=>$names,
            'thumbnail'=>$image,
            'status'=>$request->status

    ]);
        return redirect()->route('galleries.index')
                ->with('success_message','Category Video added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $carving_video
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $carving_video)
    {
        return view('galleries.show')->with('carving_video',$carving_video);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $carving_video
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $carving_video)
    {

        return view('galleries.create')->with('carving_video',$carving_video);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $carving_video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $carving_video)
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
       
        return redirect()->route('galleries.index')
                ->with('success_message','Category Video updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $carving_video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $carving_video)
    {
        $carving_video->delete();
        return redirect()->route('galleries.index')
                ->with('success_message','Category Video deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Gallery  $carving_video
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $carving_video=Gallery::where('id',$request->id)->first();
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
     * @param  \App\Gallery  $carving_video
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Gallery::where([
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
