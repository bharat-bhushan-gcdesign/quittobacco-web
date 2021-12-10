<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Relationship extends Model
{
    protected $table='relationship';

    public function getRouteKeyName()
    {
        return 'code';
    }
    public static function boot(){
        parent::boot();
       
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id','DESC');
        });

        static::creating(function($relationship){
            do {
                $code=Str::random(8);
            } while (Relationship::where('code', $code)->exists());
            $relationship->code=$code;
        });
    }
}

	
