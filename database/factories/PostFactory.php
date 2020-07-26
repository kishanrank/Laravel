<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->unique()->paragraph(1);
    $slug = Str::slug($title, '-');
    
    return [
        'admin_id' => 1,
        'title' => $title,
        'slug' => $slug,
        'info' => $faker->paragraph(2),
        'content' => $faker->paragraph(5),
        'category_id' => implode(Category::all()->random(1)->pluck('id')->toArray()),
        'featured' => 'uploads/posts/featured/image1.png',
    ];
});
