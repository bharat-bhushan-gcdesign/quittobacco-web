<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subscriptions.index')->with('subscriptions',Subscription::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subscriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subscription=Subscription::firstOrCreate([
            'title'=>ucwords(strtolower($request->title)),
            'description'=>ucwords(strtolower($request->description)),
            'amount'=>$request->amount,
            'status'=>$request->status
        ]);

        return redirect()->route('subscriptions.index')
                ->with('success_message','Subscription added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        return view('subscriptions.show')->with('subscription',$subscription);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        return view('subscriptions.create')->with('subscription',$subscription);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $subscription->update([
            'title'=>ucwords(strtolower($request->title)),
            'description'=>ucwords(strtolower($request->description)),
            'amount'=>$request->amount,
            'status'=>$request->status
        ]);
        return redirect()->route('subscriptions.index')
                ->with('success_message','Subscription updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('subscriptions.index')
                ->with('success_message','Subscription deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $subscription=Subscription::where('id',$request->id)->first();
        if(is_object($subscription)){
            $subscription->update([
                'status'=>$request->status=="false" ? 0 : 1
            ]);
            return "success";
        }
        else
            return "failed";
    } 
      /**
     * Check Exist 
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Subscription::where([
                'title'=>$request->title,
                'status'=>1
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
