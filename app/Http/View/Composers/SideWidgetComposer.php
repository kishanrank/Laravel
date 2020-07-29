<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\View\View;

class SideWidgetComposer
{
    public function compose(View $view) {
        $view->with('sideWidgetCategory', Category::orderBy('name', 'ASC')->has('posts')->get()->take(10))
            ->with('sideWidgetTag', Tag::orderBy('tag', 'ASC')->whereHas('posts')->get());
    }
}
