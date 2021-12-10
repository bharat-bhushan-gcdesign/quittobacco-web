<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserQuitPlan extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //  if($this->steps != NULL)
        //     return [
        //     'env_challenge'=>[
        //         'step'=>$this->steps
        //     ],    
        // ];
        // elseif ($this->challenge != NULL && $this->copying_strategy) 
        //     return [
        //     'personal_challenge'=>[
        //         'challenge'=>$this->challenge,
        //         'copying_strategy'=>$this->copying_strategy,
        //     ]
        // ];
        // else
        return [

            'env_challenge'=>[
                'step'=>$this->steps
            ], 
            'personal_challenge'=>[
                'challenge'=>$this->challenge,
                'copying_strategy'=>$this->copying_strategy,
            ]
            
        ];
    }
}
