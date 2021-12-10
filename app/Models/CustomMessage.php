<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomMessage extends Model
{
    protected $table='custom_message';

    public function getRouteKeyName()
    {
        return 'code';
    }

}
