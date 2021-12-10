<?php

namespace App\Exports;

use App\Models\Orders;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class orderExport implements FromView
{
    public function view(): View
    {
    	$restaurant = request()->input('restaurant');
        $pastOrder = Orders::with('menu','restaurants','user','currencyData')->where('restaurants_id',$restaurant)->where('order_status','7')->get();
        
       
    	$data['orders'] = $pastOrder;
    	
    	//echo json_encode($pastOrder);exit;
        return view('exports.order', $data);
    }
}