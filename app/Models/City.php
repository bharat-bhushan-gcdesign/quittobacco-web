<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class City extends Model
{
    protected $table='cities';

     public function country()
    {
    	  return $this->belongsTo(Country::class,'country_id');
    }
     public function state()
    {
    	  return $this->belongsTo(States::class,'state_id');
    }

    public function getRouteKeyName()
	{
	    return 'code';
	}

	public static function boot(){
        parent::boot();
       
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id','DESC');
        });
        static::creating(function($city){
            do {
                $code=Str::random(32);
            } while (City::where('code', $code)->exists());
            $city->code=$code;
        });
    }


}
