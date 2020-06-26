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
        'name', 'email', 'password', 'admin', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function isUserActivated() {
        if($this->active) {
            return true;
        }
        return false;
    }

    public function userActivationCode() {
        return $this->hasOne(ActivationCode::class);
    }

    public function isAdmin() {
        if ($this->admin == 1) {
            return true;
        }
        return false;
    }

    public function getId()
    {
      return $this->id;
    }
}
