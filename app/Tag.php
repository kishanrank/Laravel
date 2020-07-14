<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag', 'slug', 'description'];

    protected $hidden = ['pivot'];

    public  function posts()
    {
        return $this->belongsToMany(Post::class);
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
