<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    protected $table = 'admin_profiles';

    protected $fillable = ['admin_id', 'about', 'linkedin', 'github', 'twitter', 'instagram', 'avatar'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}