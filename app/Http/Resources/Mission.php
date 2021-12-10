<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class Mission extends JsonResource
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
            // 'name'=>$this->name,
            'notes'=>$this->notes,
            'code'=>$this->code,
            
            // 'image'=>$this->file->name,
            
        ];
    }
}
