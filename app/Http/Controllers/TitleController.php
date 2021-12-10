<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Title;
use App\Models\Userpermissions;
use Illuminate\Support\Facades\Auth;

class TitleController extends Controller
{
    
    
    public function list()
    {
        $titlelist = Title::where('status','!=',2)->orderby('id','DESC')->get();
              
        return view('title.list',['titlelist'=>$titlelist]); 
            
     				   
          
    }
    public function create()
    {
    	
            $pid="";
            
                return view('title.create',['pid'=>$pid]);
           
    }
    public function savetitle(Request $request)
    {
			
   
            $id=$request->pid;
           
            if($id=="" || $id==null)
            $title = new Title;
            else
            $title = Title::find($id);

                $title->name=ucfirst(strtolower($request->name));
                $title->status=$request->status;
                $title->save();
            if($id=="" || $id==null)
            return redirect('/title')->witherrors('message','title created successfully');
            else
            return redirect('/title')->witherrors('message','title Updated successfully');
			
    }
    public function edit(Request $request,$id)
    {	
                $title = Title::where('id',$id)->where('status','!=',2)->first();
         
                  $pid=$id;
                 // dd($pid);
                  return view('title.create',['pid'=>$pid,'title'=>$title]);
                    
    }

     public function view(Request $request,$id)
    {
		//dd($id);
        $title = Title::where('status','!=',2)->where('id',$id)->first();
     
                $id=$id;
                return view('title.view',['title'=>$title,'id'=>$id]);
          
    }
    public function titledestroy(Request $request,$id)
    {
    	
                    $title = Title::where('status','!=',2)->where('id',$id)->first();
                    $title->status = 2;
                    $title->save();
                    return redirect('/title')->with('message','Title Deleted successfully');
              
    }
    public function statusupdate(Request $request)
    {
        //dd("sf");
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $check = Title::where('id',$id)->first();
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
        $users=Title::where('name', $name)->where('status',1)->where('id','!=',$pid)->count();
        if($users!=0){
        $data='false';
        }else{
        $data='true';
        }
        return $data;
    }

} 


