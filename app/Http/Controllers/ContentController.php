<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contents.index')->with('contents',Content::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $content=Content::firstOrCreate([
            'title'=>ucwords(strtolower($request->title)),
            'description'=>base64_encode(str_replace(['<p>','</p>','&nbsp;'], [" "], $request->description)),
            'status'=>$request->status
        ]);
        return redirect()->route('contents.index')
                ->with('success_message','Content added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        return view('contents.show')->with('content',$content);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        return view('contents.create')->with('content',$content);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        $content->update([
            'title'=>ucwords(strtolower($request->title)),
            'description'=>base64_encode($request->description),
            'status'=>$request->status
        ]);
        return redirect()->route('contents.index')
                ->with('success_message','Content updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        $content->delete();
        return redirect()->route('contents.index')
                ->with('success_message','Content deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {

        $content=Content::where('id',$request->id)->first();
        if(is_object($content)){
            $content->update([
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
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Content::where([
                'title'=>$request->title,
                'status'=>1
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
      /**
     * Check Null 
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function checkNull(Request $request)
    {  
        $description=str_replace(['<p>','</p>','&nbsp;'], [" "], $request->description);
        return str_word_count($description)==0 ? 'false' : 'true';
    }
}
