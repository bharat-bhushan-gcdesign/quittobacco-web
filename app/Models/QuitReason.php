<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class QuitReason extends Model
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

        static::creating(function($quit_reason){
            do {
                $code=Str::random(8);
            } while (QuitReason::where('code', $code)->exists());
            $quit_reason->code=$code;
        });
    }



}
