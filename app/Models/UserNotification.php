<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserNotification extends Model
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
        'type',
        'message',
        'seen_status',
        'positive',
        'notify_type',
        'achievement_id',
        'negative',
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
        static::creating(function($user_notification){
            do {
                $code=Str::random(8);
            } while (UserNotification::where('code', $code)->exists());
            $user_notification->code=$code;
        });
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

}
