<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\View\View;

class AdminSideBarComposer
{
    public function compose(View $view) {
        $view->with('setting', Setting::firstOrFail()->toArray());
    }
}
