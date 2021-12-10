<?php

namespace App\Http\Controllers;
use App\Models\Cities;
use App\Models\Country;
use App\Models\States;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Auth;
use DB;

class CityController extends Controller
{

    /**
     * Display a listing of the subjects.
     *
     * @return Illuminate\View\View 
     */
    public function index()
    {
        $city = cities::with('country','state')->where('status','!=',2)->get();
          // dd($city);
        return view('city.list', compact('city'));
    }
    public function create()
    {
        $states = States::where('status',1)->pluck('name','id');
        $country = Country::where('status',1)->pluck('name','id');
        $pid="";
        // dd($cities->id);
        return view('city.create',compact('states','country','pid'));
    }
    public function store(Request $request)
    {
            $c_name = strtolower($request->name);
            $name=ucfirst($c_name);
            $status=$request->status;
            $country_id=$request->country_id;
            $state_id=$request->state_id;
             if($request->pid=="")
            $state=new cities;
        else
             $state= cities::find($request->pid);
            $state->name=$name;
            $state->country_id=$country_id;
            $state->state_id=$state_id;
            $state->status=$status;
            $state->save();
            return redirect('city')
                             ->with('success_message', 'City added successfully');

       
    }
    public function edit($id)
    {
        $city = Cities::findOrFail($id);
     $states = States::where('status',1)->pluck('name','id');
        $country = Country::where('status',1)->pluck('name','id');
        $pid=$id;
        return view('city.create', compact('city','states','country','pid'));
    }

    // public function update($id, Request $request)
    // {
    //      // dd($request->all());
      
    //          $c_name = strtolower($request->name);
    //         $name=ucfirst($c_name);
    //         $status=$request->status;
    //         $country_id=$request->country_id;
    //         $state_id=$request->state_id;
    //         if($request->pid=="")
    //         $state= cities::find($id);
    //         else
    //         $state->name=$name;
    //         $state->country_id=$country_id;
    //         $state->state_id=$state_id;
    //         $state->status=$status;
    //         $state->save();

    //         return redirect('city')
    //                          ->with('success_message', 'City updated successfully');   
    // }
    /**
     * Show the form for creating a new subject.
     *
     * @return Illuminate\View\View
     */
     public function destroy($id)
    {

        try {
           
            $city = Cities::find($id);
            $city->status=2;
            $city->save();
;
           // dd($country);
         //   $country

            return redirect('city')
                             ->with('success_message', 'City Was Deleted successfully');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => trans('subjects.unexpected_error')]);
        }
    }
    public function statelist(Request $request)
    {

        $ParentID = $request->get('q');
        //dd($ParentID);
        return States::where('country_id', $ParentID)->get(['id', 'name as text']);
    } 
    public function getstatelist(Request $request)
    {
        $ParentID = $request->get('q');
        $statelist =States::where('country_id', $ParentID)->where('status',1)->pluck('name', 'id');
        $result = "<option value=''>Please select State</option>";
        foreach($statelist as $k=>$v)
        {
            $result .="<option value='".$k."'>".$v."</option>";
        }
     
        return $result;
    } 
    public function getcitylist(Request $request)
    {
        $ParentID = $request->get('q');
        $citylist =cities::where('state_id', $ParentID)->where('status',1)->pluck('name', 'id');
        $result = "<option value=''>Please select City</option>";
        foreach($citylist as $k=>$v)
        {
            $result .="<option value='".$k."'>".$v."</option>";
        }
        return $result;
    }

        public function cityname(Request $request)
    {
        //dd($request->all());
        $data='';
        $pid=$request->id?$request->id:0;
        $cid=$request->country_id;
        $sid=$request->state_id;
        $name=ucfirst(strtolower($request->name));
        $users=Cities::where('country_id',$cid)->where('state_id',$sid)->where('name', $name)->where('status',1)->where('id','!=',$pid)->count();
        if($users!=0){
        $data='false';
        }else{
        $data='true';
        }
        return $data;
    }

    public function statusupdate(Request $request)
    {
       // dd($request->all());
        $id = $request->id;
        $status = $request->status=="false" ? 0 : 1;

        $check = Cities::where('id',$id)->first();
        if(is_object($check))
        {
           // dd($check);
            $check->status = $status;
            $check->save();
          //  dd($check);
            return "success";
        }
        else
        return "failed";
    }

}
