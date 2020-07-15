<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use Notifiable;

    protected $table = 'subscribers';

    protected $dates = ['deleted_at'];
    
    protected $fillable = ['email'];
}
