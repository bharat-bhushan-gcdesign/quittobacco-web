<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Currency extends JsonResource
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
            'name'=>$this->name,
            'symbol'=>$this->symbol,
            'digital_code'=>$this->digital_code,
            'country'=>$this->country,
            'description'=>$this->description,
            
            'code'=>$this->code,
        ];
    }
}
