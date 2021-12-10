<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Faq extends Model
{
    protected $table='faq';

    public function getRouteKeyName()
    {
        return 'code';
    }

    public static function boot(){
        parent::boot();
       
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id','DESC');
        });

        static::creating(function($faq){
            do {
                $code=Str::random(32);
            } while (Faq::where('code', $code)->exists());
            $faq->code=$code;
        });
    }
}
