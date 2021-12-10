<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FirstSmokeTiming extends Model
{

    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',

        'occurence',
        'description',
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

        static::creating(function($first_smoke_timing){
            do {
                $code=Str::random(32);
            } while (FirstSmokeTiming::where('code', $code)->exists());
            $first_smoke_timing->code=$code;
        });
    }

    public function user_information(){
        return $this->hasOne('App\Models\user_information');
    }

}
