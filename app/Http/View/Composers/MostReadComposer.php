<?php

namespace App\Http\View\Composers;

use App\Models\Post;
use Illuminate\View\View;

class MostReadComposer
{
    public function compose(View $view)
    {
        $view->with('mostReadPosts', Post::where('id', '<=', '5')->take(5)->get());
    }
}
