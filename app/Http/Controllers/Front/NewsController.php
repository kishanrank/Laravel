<?php

namespace App\Http\Controllers\Front;

use App\News;
use App\Http\Controllers\ResponserController;
use Illuminate\Http\Request;

class NewsController extends ResponserController
{
    public function allNews() {
    	$allNews = News::all();
    	return view('front.news.index', compact('allNews'));
    }

    public function singleNews($slug) {
    	$news = News::where('slug', $slug)->firstOrFail();
    	return view('front.news.single', compact('news'));
    }
}
