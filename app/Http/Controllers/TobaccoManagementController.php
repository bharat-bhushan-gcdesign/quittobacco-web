<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\TobaccoManagement;
use App\Models\Userpermissions;
use Illuminate\Support\Facades\Auth;

class TobaccoManagementController extends Controller
{
    
    
    public function list()
    {
        $tobaccolist = TobaccoManagement::where('status','!=',2)->get();
              
        return view('tobaccoManagement.list',['tobaccolist'=>$tobaccolist]); 
        
        //echo "Hai";
     				   
          
    }
    public function create()
    {
    	
            $pid="";
            
                return view('tobaccoManagement.create',['pid'=>$pid]);
           
    }
    public function savetitle(Request $request)
    {
			
   
            $id=$request->pid;
           
            if($id=="" || $id==null)
            $tobacco = new TobaccoManagement;
            else
            $tobacco = TobaccoManagement::find($id);

                $tobacco->name=ucfirst(strtolower(trim($request->name)));
                $tobacco->status=$request->status;
                $tobacco->save();
            if($id=="")
            return redirect('/tobacco_management')->witherrors('message','Tobacco Management created successfully');
            else
            return redirect('/tobacco_management')->witherrors('message','Tobacco Management Updated successfully');
			
    }
    public function edit(Request $request,$id)
    {	
                $tobacco = TobaccoManagement::where('id',$id)->where('status','!=',2)->first();
         
                  $pid=$id;
                 // dd($pid);
                  return view('tobaccoManagement.create',['pid'=>$pid,'tobacco'=>$tobacco]);
                    
    }

     public function view(Request $request,$id)
    {
		//dd($id);
        $tobacco = TobaccoManagement::where('status','!=',2)->where('id',$id)->first();
     
                $id=$id;
                return view('tobaccoManagement.view',['tobacco'=>$tobacco,'id'=>$id]);
          
    }
    public function titledestroy(Request $request,$id)
    {
                    $tobacco = TobaccoManagement::where('status','!=',2)->where('id',$id)->first();
                    $tobacco->status = 2;
                    $tobacco->save();
                    return redirect('/tobacco_management')->with('message','Title Deleted successfully');
              
    }
    public function statusupdate(Request $request)
    {
        //dd("sf");
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $check = TobaccoManagement::where('id',$id)->first();
        //dd($check->status);
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
        $users=TobaccoManagement::where('name', $name)->where('status','!=',2)->where('id','!=',$pid)->count();
        if($users!=0){
        $data='false';
        }else{
        $data='true';
        }
        return $data;
    }

} 


