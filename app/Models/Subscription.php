<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',

        'title',
        'amount',
        'description',
        'status' /** 0 => Inactive 1 => Active*/
    ];

 	public function scopeStatus($query)
    {
        return $query->where('status', 1);
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

        static::creating(function($subscription){
            do {
                $code=Str::random(32);
            } while (Subscription::where('code', $code)->exists());
            $subscription->code=$code;
        });
    }

}
