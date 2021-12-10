<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Motivation extends JsonResource
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
            'request'=>$this->request,
            'code'=>$this->code,
            
            'file'=> $this->file!= null ? $this->file->name : "",
        ];
    }
}
