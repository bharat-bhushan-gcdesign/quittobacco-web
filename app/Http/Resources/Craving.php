<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;
use Carbon\Carbon;

class Craving extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        switch (\Request::route()->getName()) {
            case 'api.cravings.graph'  :
                return [
                    // 'id'=>$this->id,
                    // 'rate'=>$this->rate,
                    'x'=>$this->created_at->format('d/m/y'),
                    'y'=>$this->tobacco_rating,
                    'date'=>$this->created_at->timestamp,
                    'code'=>$this->code,


                ];

            case 'api.dashboard'  :
                return [
                    'x'=>$this->created_at->format('d/m/y'),
                    'y'=>$this->tobacco_rating,
                    'date'=>$this->created_at->timestamp,
                    'code'=>$this->code,

                ];    

            case 'api.cravings.list':
                return [
                    'id'=>$this->id,
                    'rate'=>$this->rate,
                    'trigger'=> $this->with_whom_id != null ? $this->withWhom->relation : "",
                    'date'=>$this->created_at->timestamp,
                    'tobacco_rating'=>$this->tobacco_rating,
                    'code'=>$this->code,

                ];


            case 'api.cravings.trigger':
                return [
                    'id'=>$this->id,
                    'rate'=>$this->rate,
                    'trigger'=> $this->comments,
                    'created_at'=>$this->created_at->timestamp,
                    'tobacco_rating'=>$this->tobacco_rating,
                    'code'=>$this->code,


                ];

            default:
                return [
                    'id'=>$this->id,
                    'how_long_did_craving_lasted'=>$this->rate,
                    'what_triggered_you'=>$this->comments,
                    'tobacco_rating'=>$this->tobacco_rating,
                    'created_at'=>$this->created_at->timestamp,
                    'code'=>$this->code,

                ];

        }
        
    }
}
