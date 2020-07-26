<?php

namespace App\Models;

use App\Notifications\Admin\ResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    const REDIRECT_TO = 'admin/home';
    const REDIRECT_TO_AFTER_RESET_PASSWORD = 'admin/login';


    protected $table = 'admins';

    protected $fillable = [
        'name', 'email', 'password', 'active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile() {
        return $this->hasOne(AdminProfile::class);
    }

    public function isAdminActivated() {  /// during login check
        if($this->active) {
            return true;
        }
        return false;
    }

    public function adminActivationCode() {
        return $this->hasOne(AdminActivationCode::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
