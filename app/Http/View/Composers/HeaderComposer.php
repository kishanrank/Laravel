<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view) {
        $view->with('headerCategories', Category::take(6)->orderBy('id', 'asc')->get())
        ->with('setting', Setting::first());
    }
}
