<?php

namespace App\Providers;

use App\Http\View\Composers\HeaderComposer;
use Illuminate\Routing\UrlGenerator;
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
    public function boot(UrlGenerator $url)
    {
        if(env('APP_ENV') !== 'local')
        {
            $url->forceSchema('https');
        }
        View::composer(['*'], HeaderComposer::class);
        View::composer(['*'], SideWidgetComposer::class);
    }
}
