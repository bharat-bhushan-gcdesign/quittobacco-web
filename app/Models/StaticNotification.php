<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class StaticNotification extends Model
{
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'code',

        'message',
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

        static::creating(function($static_notification){
            do {
                $code=Str::random(32);
            } while (StaticNotification::where('code', $code)->exists());
            $static_notification->code=$code;
        });
    }
   
    

}
