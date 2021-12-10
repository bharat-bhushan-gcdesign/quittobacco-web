<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Userpermissions;
use Auth;

class FaqController extends Controller
{

     public function list()
    {
    	
        $faq=Faq::where('status','!=',2)->get();     
    	return view('faq.list', compact('faq'));
    }
      public function create()
    {
    	$pid="";
    	return view('faq.create', compact('pid'));
    }
     public function savefaq(Request $request)
    {   
    //	dd($request->all());
    	$id=$request->pid;
    	if($id=="")
    	 $ad = new Faq;
    	else
    	  $ad =Faq::find($id);
    	$ad->question=base64_encode($request->name);
    	$ad->description=base64_encode($request->description);
      $ad->status=$request->status;
    	$ad->created_by=Auth::user()->id;

    	         
         $ad->save(); 
         if($id=="")
         return redirect('/faq')->witherrors('Faq Added successfully');
         else
         return redirect('/faq')->witherrors('Faq Updated successfully');
    }
    public function view($id)
    {
    	 $faq=Faq::find($id);
       $id=$id;
    	return view('faq.view', compact('faq','id'));
    }
      public function edit($id)
    {
    	 $faq=Faq::find($id);
    	 $pid=$id;
    	 return view('faq.create', compact('pid','faq'));
    }
    public function faqdestory($id)
    {
    	$faq=Faq::find($id);
    	$faq->status=2;
    	   $faq->save();
             //dd($country);
            return redirect()->back()->with('message','FAQ Deleted successfully');

    }
     public function statusupdate(Request $request)
    {
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $check = Faq::where('id',$id)->first();
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
