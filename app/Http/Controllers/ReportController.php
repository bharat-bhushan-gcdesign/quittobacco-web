<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Subscription;
use App\Models\Eventtype;
use App\Models\Relationship;
use App\Models\Userpermissions;
use Illuminate\Support\Facades\Auth;
use DB;
use Excel;
use PDF;

class ReportController extends Controller
{
    /*created date 19.02.2020
     function for:   list for relationship 
     input fields:*/ 
    public function list()
    {
        $report = Users::where('status','!=',2)->where('role','=',2)->orderby('id','DESC')->get();     
        return view('report.user.list',['report'=>$report]);       
    }
    public function export_user(Request $request)
      {
        if($request->type == 'pdf' && $request->start_date == '' && $request->end_date == ''){
            // Fetch all customers from database
            $userlist = Users::where('status','!=',2)->where('role','=',2)->orderby('id','DESC')->get();
            // Send data to the view using loadView function of PDF facade
            $pdf = PDF::loadView('report.user.view', compact('userlist'));
            // If you want to store the generated pdf to the server then you can use the store function
            //$pdf->save(storage_path().'_filename.pdf');
            // Finally, you can download the file using download function
            return $pdf->download('Users' . date("d-m-Y H:i:m") . '.pdf');
        }
        else if($request->type == 'csv' && $request->start_date == '' && $request->end_date == '')
        {
            $userlist = Users::where('status','!=',2)->where('role','=',2)->orderby('id','DESC')->get();
                ob_start();
                $headerArr = array('Sno', 'Name', 'Email', 'Product Name', 'Status', 'Created Date');
                foreach ($headerArr as $value) {
                    $headerArr[4] = $value;
                };
                //dd($headerArr);
                $filename = "file.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, $headerArr);
                $i = 1;
                foreach ($userlist as $key => $user) {
                    //dd($student['full_name']);
                    if($user->status == '0')
                    {
                        $status = 'Inactive';
                    }
                    if($user->status == '1')
                    {
                        $status = 'Active';
                    }
                    if($user->status == '2')
                    {
                        $status = 'Delete';
                    }
                    $userlist = array($i, $user->Name, $user->email, $user->mobile, $status, date('d-m-Y', strtotime($user->created_at)));
                    fputcsv($handle, $userlist);
                    $i++;
                }
                fclose($handle);
                $headers = array(
                    'Cache-Control' => 'nocache, no-store, max-age=0, must-revalidate',
                    'Pragma', 'no-cache',
                    'Expires', 'Fri, 01 Jan 1990 00:00:00 GMT',
                );



                return response()->download($filename, 'Users' . date("d-m-Y H:i:m") . '.csv', $headers);
            }
            else if($request->type == 'pdf' && $request->start_date != '' && $request->end_date == '')
            {
                //DB::enableQueryLog();
                // Fetch all customers from database
                $userlist = Users::where('created_at', '>=', $request->start_date.'%')->where('status','!=',2)->where('role','=',2)->orderby('id','DESC')->get();
                //dd(DB::getQueryLog());
                // Send data to the view using loadView function of PDF facade
                $pdf = PDF::loadView('report.user.view', compact('userlist'));
                // If you want to store the generated pdf to the server then you can use the store function
                //$pdf->save(storage_path().'_filename.pdf');
                // Finally, you can download the file using download function
                return $pdf->download('Users' . date("d-m-Y H:i:m") . '.pdf');
            }
            else if($request->type == 'csv' && $request->start_date != '' && $request->end_date == '')
            {
                $userlist = Users::where('created_at', '>=', $request->start_date.'%')->where('status','!=',2)->where('role','=',2)->orderby('id','DESC')->get();
                ob_start();
                $headerArr = array('Sno', 'Name', 'Email', 'Product Name', 'Status', 'Created Date');
                foreach ($headerArr as $value) {
                    $headerArr[4] = $value;
                };
                //dd($headerArr);
                $filename = "file.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, $headerArr);
                $i = 1;
                foreach ($userlist as $key => $user) {
                    //dd($student['full_name']);
                    if($user->status == '0')
                    {
                        $status = 'Inactive';
                    }
                    if($user->status == '1')
                    {
                        $status = 'Active';
                    }
                    if($user->status == '2')
                    {
                        $status = 'Delete';
                    }
                    $userlist = array($i, $user->Name, $user->email, $user->mobile, $status, date('d-m-Y', strtotime($user->created_at)));
                    fputcsv($handle, $userlist);
                    $i++;
                }
                fclose($handle);
                $headers = array(
                    'Cache-Control' => 'nocache, no-store, max-age=0, must-revalidate',
                    'Pragma', 'no-cache',
                    'Expires', 'Fri, 01 Jan 1990 00:00:00 GMT',
                );



                return response()->download($filename, 'Users' . date("d-m-Y H:i:m") . '.csv', $headers);
            }
            else if($request->type == 'pdf' && $request->start_date != '' && $request->end_date != '')
            {
                //DB::enableQueryLog();
                // Fetch all customers from database
                $userlist = Users::where('created_at', '>=', $request->start_date.'%')->where('created_at', '<=', $request->end_date.'%')->where('status','!=',2)->where('role','=',2)->orderby('id','DESC')->get();
                //dd(DB::getQueryLog());
                // Send data to the view using loadView function of PDF facade
                $pdf = PDF::loadView('report.user.view', compact('userlist'));
                // If you want to store the generated pdf to the server then you can use the store function
                //$pdf->save(storage_path().'_filename.pdf');
                // Finally, you can download the file using download function
                return $pdf->download('Users' . date("d-m-Y H:i:m") . '.pdf');
            }
            else if($request->type == 'csv' && $request->start_date != '' && $request->end_date != '')
            {
                //DB::enableQueryLog();
                $userlist = Users::where('created_at', '>=', $request->start_date.'%')->where('created_at', '<=', $request->end_date.'%')->where('status','!=',2)->where('role','=',2)->orderby('id','DESC')->get();
                //dd(DB::getQueryLog());
                ob_start();
                $headerArr = array('Sno', 'Name', 'Email', 'Product Name', 'Status', 'Created Date');
                foreach ($headerArr as $value) {
                    $headerArr[4] = $value;
                };
                //dd($headerArr);
                $filename = "file.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, $headerArr);
                $i = 1;
                foreach ($userlist as $key => $user) {
                    //dd($student['full_name']);
                    if($user->status == '0')
                    {
                        $status = 'Inactive';
                    }
                    if($user->status == '1')
                    {
                        $status = 'Active';
                    }
                    if($user->status == '2')
                    {
                        $status = 'Delete';
                    }
                    $userlist = array($i, $user->Name, $user->email, $user->mobile, $status, date('d-m-Y', strtotime($user->created_at)));
                    fputcsv($handle, $userlist);
                    $i++;
                }
                fclose($handle);
                $headers = array(
                    'Cache-Control' => 'nocache, no-store, max-age=0, must-revalidate',
                    'Pragma', 'no-cache',
                    'Expires', 'Fri, 01 Jan 1990 00:00:00 GMT',
                );



                return response()->download($filename, 'Users' . date("d-m-Y H:i:m") . '.csv', $headers);
            }
        }
    /*created date 19.02.2020
     function for:   create for relationship 
     input fields:*/ 

    public function subscription_list()
    {
        $report = Subscription::orderby('id','DESC')->get();     
        return view('report.subscription.list',['report'=>$report]);       
    }

    public function export_subscription(Request $request)
      {
        if($request->start_date == '' && $request->end_date == '')
            {
            // Fetch all customers from database
            $data = Subscription::orderby('id','DESC')->get();
            }
        else if($request->start_date == '' && $request->end_date == '')
            {
            $data = Subscription::orderby('id','DESC')->get();
            }
        else if($request->start_date != '' && $request->end_date == '')
            {
                //DB::enableQueryLog();
                // Fetch all customers from database
                $data = Subscription::where('created_at', '>=', $request->start_date.'%')->orderby('id','DESC')->get();
                //dd(DB::getQueryLog());
            }
        else if($request->start_date != '' && $request->end_date != '')
            {
                //DB::enableQueryLog();
                // Fetch all customers from database
                $data = Subscription::where('created_at', '>=', $request->start_date.'%')->where('created_at', '<=', $request->end_date.'%')->orderby('id','DESC')->get();
                //dd(DB::getQueryLog());
            }
        else if($request->start_date != '' && $request->end_date != '')
            {
                //DB::enableQueryLog();
                $data = Subscription::where('created_at', '>=', $request->start_date.'%')->where('created_at', '<=', $request->end_date.'%')->orderby('id','DESC')->get();
                //dd(DB::getQueryLog());
            }
        if($request->type == 'pdf')
            {
                $subscriptionlist = $data;
                //dd(DB::getQueryLog());
                // Send data to the view using loadView function of PDF facade
                $pdf = PDF::loadView('report.subscription.view', compact('subscriptionlist'));
                // If you want to store the generated pdf to the server then you can use the store function
                //$pdf->save(storage_path().'_filename.pdf');
                // Finally, you can download the file using download function
                return $pdf->download('Subscription' . date("d-m-Y H:i:m") . '.pdf');
            }
        else if($request->type == 'csv')
            {
                //DB::enableQueryLog();
                $subscriptionlist = $data;
                //dd(DB::getQueryLog());
                ob_start();
                $headerArr = array('Sno', 'Name', 'Email', 'Product', 'Status', 'Created Date');
                foreach ($headerArr as $value) {
                    $headerArr[4] = $value;
                };
                //dd($headerArr);
                $filename = "file.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, $headerArr);
                $i = 1;
                foreach ($subscriptionlist as $key => $subscription) {
                    //dd($student['full_name']);
                    if($subscription->subscription_status == '0')
                    {
                        $status = 'Pending';
                    }
                    if($subscription->subscription_status == '1')
                    {
                        $status = 'Approve';
                    }
                    $subscriptionlist = array($i, $subscription->customer_name, $subscription->customer_email, $subscription->product_name, $status, date('d-m-Y', strtotime($subscription->created_at)));
                    fputcsv($handle, $subscriptionlist);
                    $i++;
                }
                fclose($handle);
                $headers = array(
                    'Cache-Control' => 'nocache, no-store, max-age=0, must-revalidate',
                    'Pragma', 'no-cache',
                    'Expires', 'Fri, 01 Jan 1990 00:00:00 GMT',
                );



                return response()->download($filename, 'Subscription' . date("d-m-Y H:i:m") . '.csv', $headers);
            }
        }

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


