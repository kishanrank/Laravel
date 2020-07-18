<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    const PUBLISHED = 1;
    const NOT_PUBLISHED = 0;

    protected $fillable = [
        'user_id', 'title', 'info', 'content', 'category_id', 'featured', 'slug', 'meta_title', 'meta_description'
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

    public function tags() {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function user() {
        return $this->belongsTo(User::class);
    } 

    public function images() {
        return $this->hasMany(PostImage::class);
    }

    public static function rules($id = 0, $extrafields = [])  {
        return array_merge(
            [
                'title' => 'required|max:512',
                'info' => 'required|min:25',
                'content' => 'required|min:100',
                'category_id' => 'required',
                'tags' => 'required'
            ], $extrafields);
    }

    public function isPublished() {
        if ($this->published) {
            return self::PUBLISHED;
        }
        return self::NOT_PUBLISHED;
    }
}

