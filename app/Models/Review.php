<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Review extends Model
{
    protected $table='review';

    public function restaurant()
    {
    	  return $this->belongsTo(Restaurant::class,'restaurant_id');
    }
    public function user()
    {
        return $this->belongsTo(Users::class,'user_id');     
    }

    public static function boot(){
        parent::boot();
       
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id','DESC');
        });

        static::creating(function($review){
            do {
                $code=Str::random(8);
            } while (Review::where('code', $code)->exists());
            $review->code=$code;
        });
    }
}
