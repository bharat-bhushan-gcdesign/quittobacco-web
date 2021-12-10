<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Diary extends JsonResource
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
            'last_entry'=>$this->last_entry,
            'date'=>$this->date,
            'tobacco_desire'=>$this->tobacco_desire,
            'craving_count'=>$this->craving_count,
            'notes'=>$this->notes,
            'code'=>$this->code,

        ];
    }
}
