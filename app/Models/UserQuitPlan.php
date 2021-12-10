<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserQuitPlan extends Model
{
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'relation',
        'mobile_number',
        'quit_timestamp',
        'challenge',
        'copying_strategy',
        'steps',
        'status' /** 0 => Inactive 1 => Active*/
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    

}
