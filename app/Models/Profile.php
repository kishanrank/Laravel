<?php

namespace App\Models;

use App\Rules\MatchOldAdminPassword;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = ['user_id', 'about', 'linkedin', 'github', 'twitter', 'instagram', 'avatar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function passwordChangeRules()
    {
        return [
            'current_password' => ['required', new MatchOldAdminPassword],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8'],
        ];
    }
}
