<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Craving extends Model
{
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'carvings';

    protected $fillable = [
        'code',

    	'user_id',
        'tobacco_per_day',
        'location',
        'feeling_id',
        'doing_id',
        'tobacco_rating',
        'with_whom_id',
        'carving_status',
        'comments',
        'rate', /** How strong you use tobacco */
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

        static::creating(function($craving){
            do {
                $code=Str::random(32);
            } while (Craving::where('code', $code)->exists());
            $craving->code=$code;
        });
    }

    public function doing(){
        return $this->belongsTo('App\Models\User');
    }
    public function feeling(){
        return $this->belongsTo('App\Models\Feeling');
    }
   
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function withWhom(){
        return $this->belongsTo('App\Models\WithWhom');
    }

}
