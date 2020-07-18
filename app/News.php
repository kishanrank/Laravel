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

    public static function rules($id = 0, $extrafield = []) {
    	return array_merge([
    		'title' => 'required|unique:news,title' . ($id ? ",$id" : ''),
    		'info' => 'required|min:20',
    		'content' => 'required|min:100',
    		'meta_title' => 'required',
    		'meta_description' => 'required' 
    	], $extrafield);
    }
}
