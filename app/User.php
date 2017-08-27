<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Mail\ForgotPasswordMail;
use Mail;
use DB;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password', 'last_login', 'first_name', 'last_name', 'dob', 'gender', 'username', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['dob'];

    public $with = ['profile'];

    public function activation()
    {
        return $this->hasOne('App\Models\Activation');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'npp-user.'.$this->username;
    }

    public function dream()
    {
        return $this->hasOne('App\Models\Dream');
    }

    public function sendPasswordResetNotification($token)
    {
        Mail::to($this)->send(new ForgotPasswordMail($token));
    }

    public function getFullname()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function getRole()
    {
        return $this->roles()->first()->slug;
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function boosts()
    {
        return $this->hasMany('App\Models\Boost');
    }
}
