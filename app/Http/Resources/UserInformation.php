<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Education as EducationResource;
use App\Http\Resources\Profession as ProfessionResource;
use App\Http\Resources\FrequentSmoke as FrequentSmokeResource;
use App\Http\Resources\TobaccoProduct as TobaccoProductResource;
use App\Http\Resources\Tobacco as TobaccoResource;
use App\Http\Resources\FirstSmokeTiming as FirstSmokeTimingResource;
use Carbon\Carbon;
use App\Models\QuitReason;
use App\Models\UseReason;
use App\Models\TobaccoProduct;

class UserInformation extends JsonResource
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
            'dob'=>(new Carbon($this->date_of_birth))->format('d M Y  h:i:s a'),
            'gender'=>$this->gender,
            'first_tobacco_use_age'=>$this->first_tobacco_use_age,
            'money_spent'=>$this->money_spent,
            'usage_count'=>$this->usage_count,
            'tobacco_count'=>$this->tobacco_count,
            'how_hard_to_quit'=>$this->how_hard_to_quit,
            'quit_date'=>(new Carbon($this->quit_date_time))->format('d M Y  h:i:s a'),
            'use_reasons'=>$this->use_reasons!=null ? UseReason::whereIn('id',$this->use_reasons)->pluck('name') : [],
            'quit_reasons'=>$this->quit_reasons !=null ? QuitReason::whereIn('id',$this->quit_reasons)->select('id','name')->get() : [],
            'education'=>new EducationResource($this->education),
            'profession'=>new ProfessionResource($this->profession),
            'frequent_smoke'=>new FrequentSmokeResource($this->frequent_smoke),
            'first_smoke_timing'=>new FirstSmokeTimingResource($this->first_smoke_timing),
            'tobacco_products'=>$this->tobacco_product_id!=null ? TobaccoProduct::whereIn('id',$this->tobacco_product_id)->pluck('name') : [],
            'tobacco'=>new TobaccoResource($this->tobacco),
            'symbol'=>$this->country->currency_symbol,
            'currency'=>$this->country->currency,
            'code'=>$this->code,
        ];
    }
}
