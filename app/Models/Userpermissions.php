<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Userpermissions extends Model
{
    protected $table = 'user_permissions';

    public function module()
    {
    	return $this->belongsTo(Modules::class,'module_id');
    }
        public function getRouteKeyName()
    {
        return 'code';
    }
}
