<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];
    
    public function posts() {
         return $this->hasMany(Post::class);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucfirst($value);
    }

    public static function rules() {
        return [
            'name' => 'required|unique:categories,name', 
            'description' => 'required'
        ];
    }
}
