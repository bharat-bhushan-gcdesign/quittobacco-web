<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,SoftDeletes;
    protected $fillable = [
        'code',
        'name',
        'email',
        'fcm_token',
        'mobile',
        'password',
        'security_question',
        'azure_id',
        'apple_id',
        'facebook_id',
        'instagram_id',
        'google_id',
        'role', /* 1=> normal user, 2=>facebook, 3=>twitter, 4=>google */
        'otp',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function boot(){
        parent::boot();
        // static::addGlobalScope('status', function (Builder $builder) {
        //     $builder['dob']->format('d-m-Y');

        // });

        /**
         * Handle the user "creating" event.
         *
         * @param  \App\User  $user
         * @return void
         */
        User::creating(function($user)
        {
            do {
                $code=Str::random(32);
            } while (User::where('code', $code)->exists());
            $user->code=$code;
            // $user->first_name= ucwords(strtolower($user->first_name));
            // $user->last_name= ucwords(strtolower($user->last_name));
        });
        // User::observe(new \App\Observers\UserObserver);
    }
    public function getRouteKeyName()
    {
        return 'code';
    }
    public function feedback(){
        return $this->hasMany('App\Models\feedback');
    }

    public function cravings(){
        return $this->hasMany('App\Models\Craving');
    }

    public function user_quit_plans(){
        return $this->hasMany('App\Models\UserQuitPlan');
    }

    public function user_notifications(){
        return $this->hasMany('App\Models\UserNotification');
    }

    public function craving_videos(){
        return $this->hasMany('App\Models\CarvingVideo');
    }

    public function diaries(){
        return $this->hasMany('App\Models\Diary');
    }

    public function healthImprovement(){
        return $this->hasOne('App\Models\HealthImprovement');
    }

    public function members(){
        return $this->hasMany('App\Models\Member');
    }

    public function missions(){
        return $this->hasMany('App\Models\Mission');
    }

    public function motivation(){
        return $this->hasOne('App\Models\Motivation');
    }

    public function notification(){
        return $this->hasOne('App\Models\Notification');
    }

    public function plans(){
        return $this->hasMany('App\Models\Plan');
    }

    public function profile(){
        return $this->morphOne('App\Models\File','fileable');
    }

    
    public function user_achievements(){
        return $this->hasMany('App\Models\UserAchievement');
    }

    public function user_information(){
        return $this->hasOne('App\Models\UserInformation');
    }

    public function user_motivations(){
        return $this->hasMany('App\Models\UserMotivation');
    }

    public function userSaving(){
        return $this->hasOne('App\Models\Saving');
    }

    public function wishLists(){
        return $this->hasMany('App\Models\WishList');
    }
    public function with_whoms(){
        return $this->hasOne('App\Models\WithWhom');
    }
    
   
}
