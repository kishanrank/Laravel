<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'user_id', 'title', 'info', 'content', 'category_id', 'featured', 'slug', 'meta_title', 'meta_description'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = ['pivot'];
    // protected $with = ['tags'];

    // public $timestamps = false;

    //data is altered as per requirement during fetching 
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

