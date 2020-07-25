<?php

namespace App\Http\Controllers\Front;

use App\Models\News;
use App\Http\Controllers\ResponserController;

class NewsController extends ResponserController
{
    public function allNews() {
    	$allNews = News::paginate(10);
    	return view('front.news.index', compact('allNews'));
    }

    public function singleNews($slug) {
    	$news = News::where('slug', $slug)->firstOrFail();
    	return view('front.news.single', compact('news'));
    }
}
