<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Plan extends Model
{
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',

        'name',
        'notes',
        'user_id',
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

        static::creating(function($plan){
            do {
                $code=Str::random(8);
            } while (Plan::where('code', $code)->exists());
            $plan->code=$code;
        });
    }

    public function file(){
        return $this->morphOne('App\Models\File','fileable');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
