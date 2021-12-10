<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Commission;
use App\Models\Userpermissions;
use App\Models\Eventpayment;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{
    
    
    public function list()
    {
        $eventpayment = Commission::get();     
        return view('commission.list',['eventpayment'=>$eventpayment]);    
    }
    public function create()
    {
            $pid="";
            return view('commission.create',['pid'=>$pid]);
           
    }
    public function saveeventpayment(Request $request)
    {
			$id=$request->pid;
            if($id=="" || $id==null)
            $payment = new Commission;
            else
            $payment = Commission::find($id);
                $payment->commission    =$request->amount;
                $payment->save();
            if($id=="" || $id==null)
            return redirect('/commission')->witherrors('message','Commission created successfully');
            else
            return redirect('/commission')->witherrors('message','Commission   Updated successfully');
			
    }
    public function edit(Request $request,$id)
    {	
                $eventpayment = Commission::where('id',$id)->first();
                $pid=$id;
                return view('commission.create',['pid'=>$pid,'eventpayment'=>$eventpayment]);                 
    }

    
} 


