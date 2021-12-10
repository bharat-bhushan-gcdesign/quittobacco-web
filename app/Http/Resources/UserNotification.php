<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;
use Carbon\Carbon;

class UserNotification extends JsonResource
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
            
            "id"=>$this->id,
            "user_id"=> $this->user_id,
            "type"=> $this->type,
            "message"=> $this->message,
            "seen_status"=> $this->seen_status,
            "positive"=> $this->positive,
            "negative"=> $this->negative,
            "notify_type"=> $this->notify_type,
            "achievement_id"=> $this->achievement_id,
            "created_at"=> $this->created_at->timestamp,
            "updated_at"=> $this->updated_at->timestamp,
        ];

        
    }
}
