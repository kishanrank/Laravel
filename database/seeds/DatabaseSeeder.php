<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // $this->call(SettingsTableSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(TagSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(AdminUserSeeder::class);
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Tag::truncate();
        Category::truncate();
        Post::truncate();
        DB::table('post_tag')->truncate();

        $tagsQuantity = 50;
        $categoriesQuantity = 30;
        $postsQuantity = 200;

        factory(Tag::class, $tagsQuantity)->create();

        factory(Category::class, $categoriesQuantity)->create();

        factory(Post::class, $postsQuantity)->create()->each(
            function ($post) {
                $tags = Tag::all()->random(mt_rand(1, 3))->pluck('id');
                $post->tags()->attach($tags);
            }
        );

        // $this->call(UsersTableSeeder::class);

    }
}
