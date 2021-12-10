<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('currencies.index')->with('currencies',Currency::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $currency=Currency::firstOrCreate([
            'name'=>ucwords(strtolower($request->name)),
            'digital_code'=>$request->digital_code,
            'symbol'=>$request->symbol,
            'country'=>ucwords(strtolower($request->country)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('currencies.index')
                ->with('success_message','Currency added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return view('currencies.show')->with('currency',$currency);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view('currencies.create')->with('currency',$currency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $currency->update([
            'name'=>ucwords(strtolower($request->name)),
            'digital_code'=>$request->digital_code,
            'symbol'=>$request->symbol,
            'country'=>ucwords(strtolower($request->country)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('currencies.index')
                ->with('success_message','Currency updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('currencies.index')
                ->with('success_message','Currency deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
       
        $currency=Currency::where('id',$request->id)->first();

        if(is_object($currency)){
            $currency->update([
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
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return Currency::where([
                'name'=>$request->name,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
