<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    
    $name = $faker->unique()->word();
    $slug = Str::slug($name, '-');
    return [
        'name' => $name,
        'slug' => $slug,
        'description' => $faker->paragraph(1)
    ];
});
