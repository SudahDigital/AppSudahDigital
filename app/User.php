<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','roles',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function cities(){
        return $this->belongsTo('App\City','city_id');
    }

    public function customers(){
        return $this->hasMany('App\Customer','user_id');
    }

    public function spv(){
        return $this->hasMany('App\Spv_sales','spv_id');
    }

    public function sls_exists(){
        return $this->hasMany('App\Spv_sales','sls_id');
    }

    public function sls(){
        return $this->hasMany('App\Spv_sales','sls_id');
    }

    public function targets_nominal(){
        return $this->hasOne('App\Sales_Targets','user_id');
    }

    public function login_records(){
        return $this->hasMany('App\LoginRecord','user_id');
    }

    

    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
