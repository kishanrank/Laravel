<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $table = 'news';

    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'title', 'info', 'featured', 'content', 'slug', 'meta_title', 'meta_descrption'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
