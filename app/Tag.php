<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $table = 'tags';
    
    protected $fillable = ['tag', 'slug', 'description', 'meta_title', 'meta_description'];

    protected $hidden = ['pivot'];

    public  function posts()
    {
        return $this->belongsToMany(Post::class)->wherePublished(1);
    }

    public function setTagAttribute($value)
    {
        $this->attributes['tag'] = ucfirst($value);
    }

    public static function rules() {
        return [
            'tag' => 'required', 
            'description' => 'required'
        ];
    }
}
