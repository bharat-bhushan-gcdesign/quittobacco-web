<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Motivational extends Model
{
    protected $table='motivational_video'; 

    public function getRouteKeyName()
    {
        return 'code';
    }

	public static function boot(){
        parent::boot();
       
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id','DESC');
        });

        static::creating(function($motivational){
            do {
                $code=Str::random(8);
            } while (Motivational::where('code', $code)->exists());
            $motivational->code=$code;
        });
    }


}
