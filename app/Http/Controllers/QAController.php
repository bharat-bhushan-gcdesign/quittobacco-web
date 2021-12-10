<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\questionandanswer;
use App\Models\Userpermissions;
use Auth;

class QAController extends Controller
{

     public function list()
    {
    	
        $faq=questionandanswer::where('status','!=',2)->get();   
        //dd($faq);  
    	return view('qa.list', compact('faq'));     
    }
      public function create()
    {
    	$pid="";
    	return view('qa.create', compact('pid'));
    }
     public function save(Request $request)
    {   
   //	dd($request->all());
    	$id=$request->pid;
    	if($id=="")
    	 $ad = new questionandanswer;
    	else
    	  $ad =questionandanswer::find($id);
    	$ad->question=base64_encode($request->name);
    	$ad->answers1=base64_encode($request->Answer1);
      $ad->answers2=base64_encode($request->Answer2);
      $ad->answers3=base64_encode($request->Answer3);
      $ad->answers4=base64_encode($request->Answer4);
      $ad->status=$request->status;
  

    	         
         $ad->save(); 
         if($id=="")
         return redirect('/qa')->witherrors('Question and Answer Added successfully');
         else
         return redirect('/qa')->witherrors('Question and Answer Updated successfully');
    }
    public function view($id)
    {
    	 $faq=questionandanswer::find($id);
       $id=$id;
    	return view('qa.view', compact('faq','id'));
    }
      public function edit($id)
    {
    	 $faq=questionandanswer::find($id);
    	 $pid=$id;
    	 return view('qa.create', compact('pid','faq'));
    }
    public function destory($id)
    {
    	$faq=questionandanswer::find($id);
    	$faq->status=2;
    	   $faq->save();
             //dd($country);
            return redirect()->back()->with('message','Question and Answer Deleted successfully');

    }
     public function statusupdate(Request $request)
    {
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $check = questionandanswer::where('id',$id)->first();
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
   