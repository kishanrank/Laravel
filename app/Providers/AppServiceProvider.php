<?php

namespace App\Providers;

use App\Http\View\Composers\HeaderComposer;
use App\Http\View\Composers\MostReadComposer;
use App\Http\View\Composers\SideWidgetComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['includes.header', 'includes.footer', 'front.index'], HeaderComposer::class);
        View::composer(['includes.rightsidebar', 'front.index'], SideWidgetComposer::class);
        View::composer(['front.index', 'includes.rightsidebar'], MostReadComposer::class);
    }
}
