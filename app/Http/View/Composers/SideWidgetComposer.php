<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\View\View;

class SideWidgetComposer
{
    public function compose(View $view) {
        $view->with('sideWidgetCategory', Category::all()->take(10))
            ->with('sideWidgetTag', Tag::all());
    }
}
