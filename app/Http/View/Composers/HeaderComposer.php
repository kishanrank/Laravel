<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $view
            ->with('headerCategories', Cache::remember('headerCategories', 1800, function () {
                return Category::take(6)->orderBy('id', 'asc')->get();
            }))
            ->with('setting', Cache::remember('setting', 1800, function () {
                return Setting::first();
            }));
    }
}
