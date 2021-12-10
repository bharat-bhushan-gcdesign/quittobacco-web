<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Plan extends JsonResource
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
            
            'id'=>$this->id,
            'name'=>$this->name,
            'notes'=>$this->notes,
            'image'=>$this->file->name,
        ];
    }
}
