<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['user_id', 'title', 'info', 'featured', 'content', 'slug'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
