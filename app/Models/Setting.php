<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = ['site_name', 'site_logo', 'address', 'contact_number', 'contact_email'];

    public function getSiteLogoAttributes($value)
    {
        return asset($value);
    }
}
