<?php
namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Commission extends Model
{
    protected $table = 'commision';  

    public function getRouteKeyName()
    {
        return 'code';
    }
}
