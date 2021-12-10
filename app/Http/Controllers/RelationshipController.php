<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Eventtype;
use App\Models\Relationship;
use App\Models\Userpermissions;
use Illuminate\Support\Facades\Auth;

class RelationshipController extends Controller
{
    /*created date 19.02.2020
     function for:   list for relationship 
     input fields:*/ 
    public function list()
    {
        $relations = Relationship::where('status','!=',2)->orderby('id','DESC')->get();     
        return view('relationship.list',['relations'=>$relations]);       
    }
    /*created date 19.02.2020
     function for:   create for relationship 
     input fields:*/ 
    public function create()
    {    	
            $pid="";
            return view('relationship.create',['pid'=>$pid]);
           
    }
    public function relationtype(Request $request)
    {
        $id=$request->pid;
            if($id=="" || $id==null)
            $relation = new Relationship;
            else
            $relation = Relationship::find($id);

                $relation->name=ucfirst(strtolower($request->name));
                $relation->status=$request->status;
                $relation->save();
            if($id=="" || $id==null)
            return redirect('/relationship')->witherrors('message','Relationship Type created successfully');
            else
            return redirect('/relationship')->witherrors('message','Relationship Type Updated successfully');
			
    }
    public function edit(Request $request,$id)
    {	
                $relation = Relationship::find($id);
         
                  $pid=$id;
                 // dd($pid);
                  return view('relationship.create',['pid'=>$pid,'relation'=>$relation]);
                    
    }

     public function view(Request $request,$id)
    {
		//dd($id);
        $relation = Relationship::find($id);
     
                
                return view('relationship.view',['relation'=>$relation]);
          
    }
    public function relationdestroy(Request $request,$id)
    {
    	
                    $retails = Relationship::find($id);
                    $retails->status = 2;
                    $retails->save();
                    return redirect('/relationship')->with('message','Relationship Type Deleted successfully');
              
    }
    public function statusupdate(Request $request)
    {
        //dd("sf");
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;
        $check = Relationship::where('id',$id)->first();
        if(is_object($check))
        {
            $check->status = $status;
            $check->save();
            return "success";
        }
        else
        return "failed";
    }    


        public function checkresttype(Request $request)
    {  
        //dd($request->all());
        $data='';
        $pid=$request->id?$request->id:0;
        $name=ucfirst($request->name);
        $users=Relationship::where('name', $name)->where('status','!=',2)->where('id','!=',$pid)->count();
        if($users!=0){
        $data='false';
        }else{
        $data='true';
        }
        return $data;
    }

} 


