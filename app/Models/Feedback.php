<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Feedback extends Model
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
        'email',
        'message',
        'status' /** 0 => Inactive 1 => Active*/
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }
    public function feedbackable() { // posts
        return $this->morphTo();
    }
    public function feedbyable() { // users
        return $this->morphTo();
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

        static::creating(function($feedback){
            do {
                $code=Str::random(32);
            } while (Feedback::where('code', $code)->exists());
            $feedback->code=$code;
        });
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    

}
