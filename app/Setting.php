<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    
    protected $fillable = ['site_name', 'address', 'contact_number', 'contact_email'];
}
