<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Point extends Model
{
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',

        'points',
        'message',
        'image',
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

        static::creating(function($point){
            do {
                $code=Str::random(8);
            } while (Point::where('code', $code)->exists());
            $point->code=$code;
        });
    }

    public function file(){
        return $this->morphOne('App\Models\File','fileable');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
