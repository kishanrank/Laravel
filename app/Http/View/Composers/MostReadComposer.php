<?php

namespace App\Http\View\Composers;

use App\Post;
use Illuminate\View\View;

class MostReadComposer
{
    public function compose(View $view)
    {
        $view->with('mostReadPosts', Post::where('id', '<=', '5')->take(5)->get());
    }
}
