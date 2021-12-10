<?php

namespace App\Http\Controllers;

use App\Models\TobaccoProduct;
use App\Models\Tobacco;

use Illuminate\Http\Request;

class TobaccoProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tobacco_products.index')->with('tobacco_products',TobaccoProduct::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tobacco_products.create')->with('tobaccos',Tobacco::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tobacco_product=TobaccoProduct::firstOrCreate([
            'tobacco_id'=>$request->tobacco_id,
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);

        return redirect()->route('tobacco_products.index')
                ->with('success_message','Tobacco Product added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TobaccoProduct  $tobacco_product
     * @return \Illuminate\Http\Response
     */
    public function show(TobaccoProduct $tobacco_product)
    {
        return view('tobacco_products.show')->with('tobacco_product',$tobacco_product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TobaccoProduct  $tobacco_product
     * @return \Illuminate\Http\Response
     */
    public function edit(TobaccoProduct $tobacco_product)
    {
        return view('tobacco_products.create')->with('tobacco_product',$tobacco_product)->with('tobaccos',Tobacco::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TobaccoProduct  $tobacco_product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TobaccoProduct $tobacco_product)
    {
        $tobacco_product->update([
            'tobacco_id'=>$request->tobacco_id,
            'name'=>ucwords(strtolower($request->name)),
            'description'=>ucwords(strtolower($request->description)),
            'status'=>$request->status
        ]);
       
        return redirect()->route('tobacco_products.index')
                ->with('success_message','Tobacco Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TobaccoProduct  $tobacco_product
     * @return \Illuminate\Http\Response
     */
    public function destroy(TobaccoProduct $tobacco_product)
    {
        $tobacco_product->delete();
        return redirect()->route('tobacco_products.index')
                ->with('success_message','Tobacco Product deleted successfully');
    }
     /**
     * update status of particular resource.
     *
     * @param  \App\TobaccoProduct  $tobacco_product
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $tobacco_product=TobaccoProduct::where('id',$request->id)->first();
        if(is_object($tobacco_product)){
            $tobacco_product->update([
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
     * @param  \App\TobaccoProduct  $tobacco_product
     * @return \Illuminate\Http\Response
     */
    public function checkExist(Request $request)
    {  
        return TobaccoProduct::where([
                'name'=>$request->name,
            ])->where('id','!=',$request->id ? $request->id : 0)->count() != 0 
        ? 'false' 
        : 'true';
    }
}
