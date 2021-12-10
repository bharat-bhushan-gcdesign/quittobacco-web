<?php

namespace App\Http\Controllers;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Auth;
use DB;
use Validator;

class CountryController extends Controller
{

    /**
     * Display a listing of the subjects.
     *
     * @return Illuminate\View\View 
     */
    public function index()
    {
        $country =Country::where('status','!=',2)->get() ;
      // dd($country);
        // $country = Country::where('School_id', Auth::user()->school_id)->paginate(25);
       
        return view('country.list', compact('country'));
    }
    public function create()
    {
        $pid="";
        return view('country.create', compact('pid'));
    }
    public function store(Request $request)
    {
       
              
             
            $c_name = strtolower($request->name);
            $name=ucfirst($c_name);
            $status=$request->status;
            if($request->pid=="")
            $country=new Country;
            else
            $country=Country::find($request->pid);


            $country->name=$name;
            $country->status=$status;
            $country->save();
            
            //Country::create($data);

            return redirect('country')
                             ->with('success_message', 'Country added successfully');

       
    }
    public function edit($id)
    {
        $country = Country::findOrFail($id);
        // dd($country);
          $pid=$id;
        return view('country.create', compact('country','pid'));
    }

    // public function update($id, Request $request)
    // {
    //     // dd($request->all());
         
  
    //     try {

    //          $validator = Validator::make($request->all(), [
 
    //     'name' => 'required|unique:countries,name,'.$id,
        
    //         ]);
            
    //           if ($validator->fails()) 
    //         {   
    //             return redirect()->back()
    //                         ->withErrors($validator)
    //                         ->withInput();
    //         } 
    //         DB::table('countries')
    //                     ->where('id',$id)
    //                     ->update([
    //                     'name'        => $request->name,'status' =>$request->status
    //         ]); 
                        
    //         return redirect('country')
    //                          ->with('success_message', 'Country updated successfully');

    //     } catch (ValidationException $exception) {

    //         return back()->withInput()
    //                      ->withErrors(new \Illuminate\Support\MessageBag(['catch_exception'=>$exception]));
    //     }     
    // }
     public function destroy($id)
    {
       // dd($id);
            $country = Country::find($id);
            $country->status=2;
            $country->save();
            return redirect('country')
                             ->with('success_message', 'Country was deleted successfully');
    }
    
    /**
     * Show the form for creating a new subject.
     *
     * @return Illuminate\View\View
     */

    public function checkname(Request $request)
    {
        $data='';
        $pid=$request->id?$request->id:0;
        $name=ucfirst(strtolower($request->name));
        $users=Country::where('name', $name)->where('status','!=',2)->where('id','!=',$pid)->count();
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

        $check = Country::where('id',$id)->first();
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
