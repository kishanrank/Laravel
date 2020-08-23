<?php

namespace App\Providers;

use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use App\Repositories\Admin\Category\Eloquent\CategoryRepository;
use App\Repositories\Admin\Posts\Eloquent\PostsRepository;
use App\Repositories\Admin\Posts\PostRepositoryInterface;
use App\Repositories\Admin\Tag\Eloquent\TagRepository;
use App\Repositories\Admin\Tag\TagRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostRepositoryInterface::class, PostsRepository::class);

        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
