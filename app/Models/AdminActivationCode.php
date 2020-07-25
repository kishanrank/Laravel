<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivationCode extends Model
{
    protected $fillable = ['code'];

    protected $table = 'admin_activation_codes';

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function admin() {
        return $this->belongsTo(Admin::class);
    }
}
