<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserAchievement extends Model
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
        'achievement_id',
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
        static::creating(function($user_achievement){
            do {
                $code=Str::random(8);
            } while (UserAchievement::where('code', $code)->exists());
            $user_achievement->code=$code;
        });
    }

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function achievement(){
        return $this->belongsTo('App\Models\Achievement');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    

}
