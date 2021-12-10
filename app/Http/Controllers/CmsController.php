<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cms;
use App\Models\Userpermissions;
use Auth;

class CmsController extends Controller
{

     public function list()
    {
    	
        $cms=Cms::where('status','!=',2)->get();     
    	return view('cms.list', compact('cms'));
    }
      public function create()
    {
    	$pid="";
    	return view('cms.create', compact('pid'));
    }
     public function savecms(Request $request)
    {
    	//dd($request->all());
    	$id=$request->pid;
    	if($id=="")
    	 $ad = new Cms;
    	else
    	  $ad =Cms::find($id);
    	$ad->title=strtoupper($request->name);
    	$ad->description=base64_encode($request->description);
      $ad->status=$request->status;
    	$ad->created_by=Auth::user()->id;

    	
         $ad->save();
         if($id=="")
         return redirect('/cms')->witherrors('Cms Added successfully');
         else
         return redirect('/cms')->witherrors('Cms Updated successfully');
    }
    public function view($id)
    {
    	 $cms=Cms::find($id);
       $id=$id;
    	return view('cms.view', compact('cms','id'));
    }
      public function edit($id)
    {
    	 $cms=Cms::find($id);
    	 $pid=$id;
    	 return view('cms.create', compact('pid','cms'));
    }
    public function cmsdestory($id)
    {
    	$cms=Cms::find($id);
    	$cms->status=2;
    	   $cms->save();
             //dd($country);
            return redirect()->back()->with('message','CMS Deleted successfully');

    }
     public function statusupdate(Request $request)
    {
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $check = Cms::where('id',$id)->first();
        if(is_object($check))
        {
            $check->status = $status;
            $check->save();
            return "success";
        }
        else
        return "failed";
    }    
  
}
