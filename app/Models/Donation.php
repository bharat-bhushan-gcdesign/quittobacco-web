<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donation';

     public function titlename(){
		
		return $this->hasOne('App\Models\Title','id','title')->where('status','!=',2);
	}
	 public function user(){
		
		return $this->hasOne('App\Models\Users','id','created_by')->where('status','!=',2);
	}
}
