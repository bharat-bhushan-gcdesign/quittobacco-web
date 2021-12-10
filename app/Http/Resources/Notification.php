<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Notification extends JsonResource
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
            'diary_remainder'=>$this->diary_remainder,
            'diary_remainder_time'=>$this->diary_remainder_time,
            'mission_remainder'=>$this->mission_remainder,
            'mission_remainder_time'=>$this->mission_remainder_time,
            'general_alert'=>$this->general_alert,
            'badge'=>$this->badge,
        ];
    }
}
