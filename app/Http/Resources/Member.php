<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Member extends JsonResource
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
            'relationship'=>$this->relationship,
            'mobile'=>$this->mobile,
            'email'=>$this->email,
            'code'=>$this->code,
            'image'=> $this->file!= null ? $this->file->name : "",
            'code'=>$this->code,
            
        ];
    }
}
