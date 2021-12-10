<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserInformation extends Model
{
    use SoftDeletes;
    protected $table = 'user_informations';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'country_id',
        'user_id', 
        'education_id',
        'profession_id',
        'tobacco_id',
        'tobacco_product_id',
        'frequent_smoke_id',
        'first_smoke_timing_id',
        'first_tobacco_use_age', /** what age did you first use tobacco */
        'money_spent', /** How much spent for tobacco per day */
        'usage_count', /** How many time do you use tobacco in a day */
        'tobacco_count', /** How many pieces do you use tobacco in a day */
        'how_hard_to_quit', /** 0->Easy,1->Not so difficult, 2-> Very Difficult */
        'gender',
        'date_of_birth',
        'quit_date',
        'quit_date_time',
        'use_reasons',
        'quit_timestamp',
        'quit_reasons',
        'start_date',
        'status' /** 0 => Inactive 1 => Active*/
    ];

    protected $casts = [
        'tobacco_product_id' => 'array', // store array data
        'quit_reasons' => 'array', // store array data
        
        'use_reasons' => 'array', // store array data
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
        static::creating(function($user_information){
            do {
                $code=Str::random(8);
            } while (UserAchievement::where('code', $code)->exists());
            $user_information->code=$code;
        });
    }

    

    public function education(){
        return $this->belongsTo('App\Models\Education');
    }
    public function frequent_smoke(){
        return $this->belongsTo('App\Models\FrequentSmoke');
    }
    public function file(){
        return $this->morphOne('App\Models\File','fileable');
    }
    public function first_smoke_timing(){
        return $this->belongsTo('App\Models\FirstSmokeTiming');
    }
    public function profession(){
        return $this->belongsTo('App\Models\Profession');
    }
    public function tobacco_product(){
        return $this->belongsTo('App\Models\TobaccoProduct');
    }
    public function tobacco(){
        return $this->belongsTo('App\Models\Tobacco');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function mission(){
        return $this->belongsTo('App\Models\Mission');
    }
    public function country(){
        return $this->belongsTo('App\Models\Country');
    }
    

}
