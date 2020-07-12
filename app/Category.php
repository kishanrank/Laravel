<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];
    
    public function posts() {
         return $this->hasMany(Post::class);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucfirst($value);
    }

    // public function getCategoryList() {
    // 	// print_r($this);
    // 	return DB::table('categories')->get();
    // }
}
