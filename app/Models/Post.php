<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    const PUBLISHED = 1;
    const NOT_PUBLISHED = 0;
    const POST_FEATURED_PATH = 'uploads/posts/featured/';
    const POST_IMAGES_PATH = 'uploads/posts/images/';

    protected $fillable = [
        'admin_id', 'title', 'info', 'content', 'category_id', 'featured', 'slug', 'meta_title', 'meta_description'
    ];

    protected $dates = ['deleted_at', 'published_at'];

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

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function isPublished()
    {
        if ($this->published) {
            return self::PUBLISHED;
        }
        return self::NOT_PUBLISHED;
    }
}
