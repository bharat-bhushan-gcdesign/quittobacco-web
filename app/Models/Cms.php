<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cms extends Model
{
    protected $table='cms';

    public function getRouteKeyName()
	{
	    return 'code';
	}
}
