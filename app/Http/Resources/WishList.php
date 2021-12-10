<?php

namespace App\Http\Resources;
use Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Saving as SavingResource;

class WishList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if($this->completed_status==0){
            $remaining_days = ($this->price/Auth::user()->user_information->money_spent)<=Auth::user()->cravings->where('carving_status',0)->count() ? 0 : ($this->price/Auth::user()->user_information->money_spent)-Auth::user()->cravings->where('carving_status',0)->count(); // days you want to 

            if($remaining_days==0){
                $this->update([
                    'completed_status'=>1
                ]);
            }
        }

        if($this->completed_status==0){

            $y = floor($remaining_days/365);
            $remaining_days = $remaining_days-(365*$y);
            $m = floor($remaining_days/30);
            $remaining_days=$remaining_days-$m*30;
            $w = floor($remaining_days/7);
            $remaining_days=$remaining_days-$w*7;
            $d = floor($remaining_days);

            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'currency'=>'₹',
                'price'=>$this->price,
                'notes'=>$this->notes,
                'remaining_time'=>$y.'y-'.$m.'m-'.$w.'w-'.$d.'d',
                'image'=> $this->file!= null ? $this->file->name : "",
                'status'=>$this->completed_status,
                'code'=>$this->code
            ];
        }
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'currency'=>'₹',
            'price'=>$this->price,
            'notes'=>$this->notes,
            'image'=> $this->file!= null ? $this->file->name : "",
            'status'=>$this->completed_status,
            'code'=>$this->code
        ];
    }
}
