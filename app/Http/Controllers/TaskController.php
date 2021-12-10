<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskManagement;
use Auth;

class TaskController extends Controller
{ 

     public function list()
    {
    	
        $quitReason=TaskManagement::where('status','!=',2)->get();     
    	return view('taskManagement.list', compact('quitReason'));
    }
      public function create() 
    {
    	$pid="";
    	return view('taskManagement.create', compact('pid')); 
    }
     public function save(Request $request)
    {
    	//dd($request->all());
    	$id=$request->pid;
    	if($id=="")
    	 $ad = new TaskManagement;
    	else
    	  $ad =TaskManagement::find($id);
    	$ad->title= ucfirst(strtolower(trim($request->name)));
    	$ad->description=base64_encode($request->description);
      $ad->status=$request->status;

    	
         $ad->save();
         if($id=="")
         return redirect('/task_management')->witherrors('Reason Added successfully');
         else
         return redirect('/task_management')->witherrors('Reason Updated successfully');
    }
    public function view($id)
    {
    	 $quitReason=TaskManagement::find($id);
       $id=$id;
    	return view('taskManagement.view', compact('quitReason','id'));
    }
      public function edit($id)
    {
    	 $quitReason=TaskManagement::find($id);
    	 $pid=$id;
    	 return view('taskManagement.create', compact('pid','quitReason'));
    }
    public function destory($id)
    {
    	$quitReason=TaskManagement::find($id);
    	$quitReason->status=2;
    	   $quitReason->save();
             //dd($country);
            return redirect()->back()->with('message','Reason Deleted successfully');

    }
     public function statusupdate(Request $request)
    {
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $check = TaskManagement::where('id',$id)->first();
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
        $users=TaskManagement::where('title', $name)->where('status','!=',2)->where('id','!=',$pid)->count();
        if($users!=0){
        $data='false';
        }else{
        $data='true';
        }
        return $data;
    }
  
}
