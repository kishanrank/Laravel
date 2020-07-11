<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    $tag = $faker->unique()->word();
    $slug = Str::slug($tag, '-');
    return [
        'tag' => $tag,
        'slug' => $slug,
        'description' => $faker->paragraph(1)
    ];
});
