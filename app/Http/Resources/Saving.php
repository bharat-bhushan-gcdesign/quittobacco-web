<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Saving extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code'=>$this->code,

            'per_day'=>'₹'.$this->per_day,
            'per_week'=>'₹'.$this->per_week,
            'per_month'=>'₹'.$this->per_month,
            'per_year'=>'₹'.$this->per_year,
            'total'=>'₹7.00',
        ];
    }
}
