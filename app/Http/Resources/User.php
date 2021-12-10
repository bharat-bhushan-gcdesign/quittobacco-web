<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\File as FileResource;
use App\Http\Resources\Skill as SkillResource;
use App\Http\Resources\Location as LocationResource;

class User extends JsonResource
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
            'name'=>$this->name != null  ? $this->name : '' ,
            'email'=>$this->email = null  ? $this->email : '',
            'mobile'=>$this->mobile,
            'fcm_token'=>$this->fcm_token = null  ? $this->fcm_token : '',
            'security_question'=>$this->security_question,
            'profile_image'=>$this->profile_image,
            'questionarie_status'=>isset($this->user_information)  ? ($this->user_information->quit_date !=null ? 1 : 0) : 0,
        ];
    }
}
