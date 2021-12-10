<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMotivation extends JsonResource
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
            'message'=>$this->message,
            'image'=>$this->image!= null ? $this->image : '',
            'display_status'=>$this->default_status,
            'code'=>$this->code,

        ];
    }
}
