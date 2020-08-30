<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AdminSideBarComposer
{
    public function compose(View $view)
    {
        $view->with('setting', Cache::remember('setting', 1800, function () {
            return Setting::firstOrFail()->toArray();
        }));
    }
}
