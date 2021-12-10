<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Achievement extends Model
{
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'achievements';

    protected $fillable = [
        'code',
        
        'name',
        'days',
        'week',
        'status' /** 0 => Inactive 1 => Active*/
    ];

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }
    public static function boot(){
        parent::boot();
       
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id','DESC');
        });

        static::creating(function($achievement){
            do {
                $code=Str::random(32);
            } while (Achievement::where('code', $code)->exists());
            $achievement->code=$code;
        });
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
    public function file(){
        return $this->morphOne('App\Models\File','fileable');
    }

   
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function user_achievement(){
        return $this->belongsTo('App\Model\UserAchievement' ,'id','achievement_id');
    }
    

}
