<?php

namespace App\Http\View\Composers;

use App\Category;
use App\Setting;
use App\Tag;
use Illuminate\View\View;

class SideWidgetComposer
{
    public function compose(View $view) {
        $view->with('sideWidgetCategory', Category::all())
            ->with('sideWidgetTag', Tag::all());
    }
}
