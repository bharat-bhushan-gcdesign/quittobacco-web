<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class File extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'code',

    	'fileable_id',
    	'fileable_type',
        'name',
        'status'
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }

    /** relations */

    public function fileable() { // users, motivations
        return $this->morphTo();
    }


    public static function boot(){
        parent::boot();
       
        

        static::creating(function($file){
            do {
                $code=Str::random(6);
            } while (File::where('code', $code)->exists());
            $file->code=$code;
        });
    }

}
