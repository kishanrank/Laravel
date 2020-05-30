<?php

namespace App\Http\View\Composers;

use App\Category;
use App\Setting;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view) {
        $view->with('headerCategories', Category::all()->take(5))
        ->with('setting', Setting::first());
    }
}
