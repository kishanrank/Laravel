<?php

namespace App\Http\Controllers\Front;

use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
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
