<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Content extends JsonResource
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
            'title'=>$this->title,
            'description'=>base64_decode($this->description),
            'image'=>"user.png"
        ];
    }
}
