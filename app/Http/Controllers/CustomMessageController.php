<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomMessage;
use Auth;

class CustomMessageController extends Controller
{ 

     public function list()
    {
    	
        $customMessage=CustomMessage::where('status','!=',2)->get();     
    	return view('customMessage.list', compact('customMessage'));
    }
      public function create() 
    {
    	$pid="";
    	return view('customMessage.create', compact('pid'));
    }
     public function save(Request $request)
    {
    	//dd($request->all());
    	$id=$request->pid;
    	if($id=="")
    	 $ad = new CustomMessage;
    	else
    	  $ad =CustomMessage::find($id);
    	$ad->title= ucfirst(strtolower(trim($request->name)));
    	$ad->description=base64_encode($request->description);
      $ad->status=$request->status;
    	$ad->created_by=Auth::user()->id;

    	
         $ad->save();
         if($id=="")
         return redirect('/customMessage')->witherrors('Message Added successfully');
         else
         return redirect('/customMessage')->witherrors('Message Updated successfully');
    }
    public function view($id)
    {
    	 $customMessage=CustomMessage::find($id);
       $id=$id;
    	return view('customMessage.view', compact('customMessage','id'));
    }
      public function edit($id)
    {
    	 $customMessage=CustomMessage::find($id);
    	 $pid=$id;
    	 return view('customMessage.create', compact('pid','customMessage'));
    }
    public function destory($id)
    {
    	$customMessage=CustomMessage::find($id);
    	$customMessage->status=2;
    	   $customMessage->save();
             //dd($country);
            return redirect()->back()->with('message','Message Deleted successfully');

    }
     public function statusupdate(Request $request)
    {
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $check = CustomMessage::where('id',$id)->first();
        if(is_object($check))
        {
            $check->status = $status;
            $check->save();
            return "success";
        }
        else
        return "failed";
    }    
  public function checktitle(Request $request)
    {  
        //dd($request->all());
        $data='';
        $pid=$request->id?$request->id:0;
        $name=ucfirst($request->name);
        $users=CustomMessage::where('title', $name)->where('status','!=',2)->where('id','!=',$pid)->count();
        if($users!=0){
        $data='false';
        }else{
        $data='true';
        }
        return $data;
    }
}
