<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'info', 'content', 'category_id', 'featured', 'slug'
    ];

    protected $dates = ['deleted_at'];

    public function getFeaturedAttribute($featured)
    {
        return asset($featured);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function user() {
        return $this->belongsTo(User::class);
    } 

    public function images() {
        return $this->hasMany(PostImage::class);
    }
}

