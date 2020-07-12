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
    Route::get('/post/{slug}.html', 'SinglePostController@single')->name('post.single');
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

Route::group(
    [
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'middleware' => ['auth', 'admin']
    ],
    function () {
        Route::get('/home', 'HomeController@index')->name('admin.home');
        Route::get('/users', 'UsersController@index')->name('users.index');
        Route::post('/users/export', 'UsersController@export')->name('users.export');
        Route::post('/users/store', 'UsersController@store')->name('users.store');
        Route::delete('/users/destroy/{user}', 'UsersController@destroy')->name('users.destroy');
        Route::get('/users/makeadmin/{user}', 'UsersController@makeadmin')->name('users.makeadmin');
        Route::get('/users/removeadmin/{user}', 'UsersController@removeadmin')->name('user.removeadmin');

        Route::post('/categories/massdelete', 'CategoriesController@massDelete')->name('categories.massdelete');
        Route::post('/categories/savecsv', 'CategoriesController@savecsv')->name('categories.savecsv');
        Route::post('/categories/saveimport', 'CategoriesController@saveimport')->name('categories.saveimport');
        Route::get('/categories/export', 'CategoriesController@export')->name('categories.export');
        Route::resource('categories', 'CategoriesController');

        Route::resource('news', 'NewsController');

        Route::get('/tags/export', 'TagsController@export')->name('tags.export');
        Route::post('/tags/massdelete', 'TagsController@massDelete')->name('tags.massdelete');
        Route::post('/tags/savecsv', 'TagsController@savecsv')->name('tags.savecsv');
        Route::post('/tags/saveimport', 'TagsController@saveimport')->name('tags.saveimport');
        Route::resource('tags', 'TagsController');

        Route::get('/post/create', 'PostsController@create')->name('post.create');
        Route::get('/posts', 'PostsController@index')->name('posts');
        Route::post('/post/store', 'PostsController@store')->name('post.store');
        Route::get('/post/delete/{post}', 'PostsController@destroy')->name('post.delete');
        Route::get('/post/edit/{post}', 'PostsController@edit')->name('post.edit');
        Route::put('/post/update/{post}', 'PostsController@update')->name('post.update');

        Route::get('/trashed/posts', 'PostsController@trashed')->name('trashed.post');
        Route::get('/post/kill/{post}', 'PostsController@kill')->name('post.kill');
        Route::get('/post/restore/{post}', 'PostsController@restore')->name('post.restore');

        Route::get('/user/profile', 'ProfileController@index')->name('user.profile');
        Route::put('/user/profile/update', 'ProfileController@update')->name('user.profile.update');

        Route::get('/settings', 'SettingController@index')->name('settings');
        Route::put('/settings/update', 'SettingController@update')->name('settings.update');

        Route::get('/subscribers/export', 'SubscriberController@export')->name('subscribers.export');
        Route::post('/subscribers/massdelete', 'SubscriberController@massDelete')->name('subscribers.massdelete');
        Route::resource('subscribers', 'SubscriberController');

        Route::get('/inbox', 'InboxController@index')->name('inbox');
        Route::get('/inbox/id/{id}', 'InboxController@show')->name('inbox.show');
    }
);
