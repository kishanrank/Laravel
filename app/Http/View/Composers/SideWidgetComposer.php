<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SideWidgetComposer
{
    // public function compose(View $view) {
    //     $view->with('sideWidgetCategory', Category::with('posts')->orderBy('name', 'ASC')->get()->take(10))  //has('posts')->
    //         ->with('sideWidgetTag', Tag::orderBy('tag', 'ASC')->whereHas('posts')->get());
    // }

    public function compose(View $view)
    {
        $view
            ->with('sideWidgetCategory', Cache::remember('sideWidgetCategory', 1800, function () {
                return Category::with('posts')->orderBy('name', 'ASC')->get()->take(10);
            }))
            ->with('sideWidgetTag', Cache::remember('sideWidgetTag', 1800, function () {
                return Tag::orderBy('tag', 'ASC')->whereHas('posts')->get();
            }));
    }
}
