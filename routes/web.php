<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::group(['namespace' => 'Front'], function () {
    Route::get('/', 'HomeController@index')->name('front.home');
    Route::get('/autocomplete', 'HomeController@autocomplete')->name('autocomplete');
    Route::get('/result', 'HomeController@searchResult')->name('search.result');
    Route::get('/about', 'HomeController@about')->name('about');
    Route::get('/contact', 'HomeController@contact')->name('contact');
    Route::get('/post/{slug}', 'SinglePostController@single')->name('post.single');
    Route::get('/category/{categoryslug}', 'PostByCategoryController@postsByCategory')->name('posts.by.category');
    Route::get('/tag/{tagslug}', 'PostByTagController@postsByTag')->name('posts.by.tag');
    Route::get('/news/all', 'NewsController@allNews')->name('news');
    Route::get('/news/{slug}', 'NewsController@singleNews')->name('news.single');
    Route::get('/aboutus', 'AboutUsController@index')->name('aboutus');
    Route::get('/contactus', 'ContactUsController@index')->name('contactus');
    Route::post('/contactus', 'ContactUsController@store')->name('contactus.store');
    Route::post('/subscribe', 'SubscriberController@subscribe')->name('subscribe');
});

Route::get('/activate/{code}', 'ActivationCodeController@activation')->name('activate.account');
Route::get('/resend/code', 'ActivationCodeController@resend')->name('resend.code');

//Admin Auth Routes
Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function () {

    Route::namespace('Auth')->group(function () {
        //Login Routes
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login')->name('postlogin');
        Route::post('/logout', 'LoginController@logout')->name('logout');
        //Forgot Password Routes
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        //Reset Password Routes
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.update');
        // admin account activation
        Route::get('/activate/{code}', 'ActivationController@activation')->name('activate.account');
        Route::get('/resend/code', 'ActivationController@resend')->name('resend.code');
    });
    Route::get('/home', 'HomeController@index')->name('home')->middleware('auth:admin');
});
//Admin Auth Routes End

Route::group(
    [
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'middleware' => ['auth:admin']
    ],
    function () {
        Route::get('/users', 'UsersController@index')->name('users.index');
        Route::post('/users/export', 'UsersController@export')->name('users.export');
        Route::post('/users/store', 'UsersController@store')->name('users.store');
        Route::delete('/users/destroy/{user}', 'UsersController@destroy')->name('users.destroy');

        Route::get('/account/profile', 'ProfileController@index')->name('admin.profile');
        Route::post('/profile/password/update', 'ProfileController@updatePassword')->name('admin.password.change');
        Route::put('/account/profile/update', 'ProfileController@update')->name('admin.profile.update');
        Route::resource('admins', 'AdminController');

        Route::post('/categories/massdelete', 'CategoriesController@massDelete')->name('categories.massdelete');
        Route::post('/categories/savecsv', 'CategoriesController@savecsv')->name('categories.savecsv');
        Route::post('/categories/saveimport', 'CategoriesController@saveimport')->name('categories.saveimport');
        Route::get('/categories/export', 'CategoriesController@export')->name('categories.export');
        Route::resource('categories', 'CategoriesController');

        Route::get('/news', 'NewsController@index')->name('news.index');
        Route::get('/news/create', 'NewsController@create')->name('news.create');
        Route::post('/news/store', 'NewsController@store')->name('news.store');
        Route::get('/news/delete/{news}', 'NewsController@destroy')->name('news.destroy');
        Route::get('/news/edit/{news}', 'NewsController@edit')->name('news.edit');
        Route::put('/news/update/{news}', 'NewsController@update')->name('news.update');

        Route::get('/news/published', 'News\PublishedController@published')->name('news.published');
        Route::get('/news/{id}/publish',  'News\PublishedController@publishNews')->name('news.make.published');
        Route::get('/news/{id}/unpublish',  'News\PublishedController@unPublishNews')->name('news.make.unpublished');

        Route::get('/news/trashed', 'News\TrashedController@trashed')->name('news.trashed');
        Route::get('/news/{id}/kill', 'News\TrashedController@kill')->name('news.kill');
        Route::get('/news/{id}/restore', 'News\TrashedController@restore')->name('news.restore');

        Route::get('/tags/export', 'TagsController@export')->name('tags.export');
        Route::post('/tags/massdelete', 'TagsController@massDelete')->name('tags.massdelete');
        Route::post('/tags/savecsv', 'TagsController@savecsv')->name('tags.savecsv');
        Route::post('/tags/saveimport', 'TagsController@saveimport')->name('tags.saveimport');
        Route::resource('tags', 'TagsController');

        Route::get('/post/create', 'PostsController@create')->name('post.create');
        Route::get('/post/show/{post}', 'PostsController@show')->name('post.show');
        Route::get('/posts', 'PostsController@index')->name('posts');
        Route::post('/post/store', 'PostsController@store')->name('post.store');
        Route::get('/post/delete/{post}', 'PostsController@destroy')->name('post.delete');
        Route::get('/post/edit/{post}', 'PostsController@edit')->name('post.edit');
        Route::put('/post/update/{post}', 'PostsController@update')->name('post.update');

        Route::get('/posts/published', 'Post\PublishedController@published')->name('posts.published');
        Route::get('/posts/{id}/publish',  'Post\PublishedController@publishPost')->name('post.make.published');
        Route::get('/posts/{id}/unpublish',  'Post\PublishedController@unPublishPost')->name('post.make.unpublished');
        
        Route::get('/posts/trashed', 'Post\TrashedController@trashed')->name('posts.trashed');
        Route::get('/post/kill/{post}', 'Post\TrashedController@kill')->name('post.kill');
        Route::get('/post/restore/{post}', 'Post\TrashedController@restore')->name('post.restore');

        Route::get('/settings', 'SettingController@index')->name('settings');
        Route::put('/settings/update', 'SettingController@update')->name('settings.update');

        Route::get('/subscribers/export', 'SubscriberController@export')->name('subscribers.export');
        Route::post('/subscribers/massdelete', 'SubscriberController@massDelete')->name('subscribers.massdelete');
        Route::resource('subscribers', 'SubscriberController');

        Route::get('/inbox', 'InboxController@index')->name('inbox');
        Route::get('/inbox/id/{id}', 'InboxController@show')->name('inbox.show');
    }
);
