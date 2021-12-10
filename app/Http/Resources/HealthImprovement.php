<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HealthImprovement extends JsonResource
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
            'id'=>$this->id,
            'oxygen_level'=>$this->oxygen_level,
            'lungs'=>$this->lungs,
            'carbon_monoxide_level'=>$this->carbon_monoxide_level,
            'code'=>$this->code,
            
        ];
    }
}
