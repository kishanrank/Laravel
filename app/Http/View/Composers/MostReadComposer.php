<?php

namespace App\Http\View\Composers;

use App\Models\Post;
use Illuminate\View\View;

class MostReadComposer
{
    public function compose(View $view)
    {
        $view->with('mostReadPosts', Post::whereNull('deleted_at')->where('id', '<=', '5')
                                        ->wherePublished(1)                           
                                        ->orderBy('created_at', 'desc')->take(5)->get());
    }
}
