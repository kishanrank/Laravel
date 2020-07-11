<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagArray = ['Laravel', 'Magento', 'Angular', 'Node', 'Vue'];

        foreach ($tagArray as $tag) {
        	\App\Tag::create([
	            'tag' => $tag,
	            'slug' => Str::slug($tag, '-')
        ]);
        }
    }
}
