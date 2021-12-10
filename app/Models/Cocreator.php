<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cocreator extends Model
{
    protected $table='cocreator';
	
	 protected $primaryKey = 'id';
	
	public function user(){
		
		return $this->hasOne('App\Models\Users','id','cocreator')->where('status','!=',2);
	}

	public function getRouteKeyName()
    {
        return 'code';
    }
	
}
