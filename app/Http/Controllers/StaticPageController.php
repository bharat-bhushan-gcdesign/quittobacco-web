<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StaticPage;
use Auth;

class StaticPageController extends Controller
{ 

     public function list()
    {
    	
        $quitReason=StaticPage::where('status','!=',2)->get();     
    	return view('staticPage.list', compact('quitReason'));
    }
      public function create() 
    {
    	$pid="";
    	return view('staticPage.create', compact('pid'));
    }
     public function save(Request $request)
    {
    	//dd($request->all());
    	$id=$request->pid;
    	if($id=="")
    	 $ad = new StaticPage;
    	else
    	  $ad =StaticPage::find($id);
    	$ad->title= ucfirst(strtolower(trim($request->name)));
    	$ad->description=base64_encode($request->description);
      $ad->status=$request->status;
    	$ad->created_by=Auth::user()->id;

    	
         $ad->save();
         if($id=="")
         return redirect('/static_page')->witherrors('Reason Added successfully');
         else
         return redirect('/static_page')->witherrors('Reason Updated successfully');
    }
    public function view($id)
    {
    	 $quitReason=StaticPage::find($id);
       $id=$id;
    	return view('staticPage.view', compact('quitReason','id'));
    }
      public function edit($id)
    {
    	 $quitReason=StaticPage::find($id);
    	 $pid=$id;
    	 return view('staticPage.create', compact('pid','quitReason'));
    }
    public function destory($id)
    {
    	$quitReason=StaticPage::find($id);
    	$quitReason->status=2;
    	   $quitReason->save();
             //dd($country);
            return redirect()->back()->with('message','Reason Deleted successfully');

    }
     public function statusupdate(Request $request)
    {
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $check = StaticPage::where('id',$id)->first();
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
        $users=StaticPage::where('title', $name)->where('status','!=',2)->where('id','!=',$pid)->count();
        if($users!=0){
        $data='false';
        }else{
        $data='true';
        }
        return $data;
    }
}
