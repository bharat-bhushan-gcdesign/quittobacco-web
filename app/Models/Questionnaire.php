<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Questionnaire extends Model
{
    protected $table='questionnaire';
	public function getRouteKeyName()
    {
        return 'code';
    }
    public static function boot(){
        parent::boot();
       
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id','DESC');
        });
        static::creating(function($questionnaire){
            do {
                $code=Str::random(8);
            } while (Questionnaire::where('code', $code)->exists());
            $questionnaire->code=$code;
        });
    }

}
