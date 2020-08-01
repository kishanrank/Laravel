<?php

namespace App\Providers;

use App\Http\View\Composers\AdminSideBarComposer;
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
        View::composer(['front.includes.header', 'front.includes.footer', 'front.index'], HeaderComposer::class);
        View::composer(['front.includes.rightsidebar', 'front.index'], SideWidgetComposer::class);
        View::composer(['front.index', 'front.includes.rightsidebar'], MostReadComposer::class);
        View::composer(['admin.includes.sidebar'], AdminSideBarComposer::class);
    }
}
