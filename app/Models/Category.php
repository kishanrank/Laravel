<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'description', 'meta_title', 'meta_description'];

    public function posts()
    {
        return $this->hasMany(Post::class)->where('published', '=', '1');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public static function rules($id = 0)
    {
        return [
            'name' => 'required|unique:categories,name' . ($id ? ",$id" : ''),
            'description' => 'required'
        ];
        // $request->validate([
        //     'email' => 'required|email|unique:users,email,'.$user->id,
        //           or   'required|email|unique:users,email,'.$this->user->id,
        // ]);
    }
}
