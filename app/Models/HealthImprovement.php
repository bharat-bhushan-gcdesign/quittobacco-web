<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HealthImprovement extends Model
{
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',

    	'user_id',
        'oxygen_level',
        'lungs',
        'carbon_monoxide_level',
        'status' /** 0 => Inactive 1 => Active*/
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }

 	public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }
    public static function boot(){
        parent::boot();
       
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id','DESC');
        });

        static::creating(function($health_improvement){
            do {
                $code=Str::random(8);
            } while (HealthImprovement::where('code', $code)->exists());
            $health_improvement->code=$code;
        });
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
