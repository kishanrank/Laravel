<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryArray = ['Laravel', 'Magento', 'Angular', 'Node', 'Vue'];

        foreach ($categoryArray as $category) {
        	\App\Category::create([
	            'name' => $category,
	            'slug' => Str::slug($category, '-')
        ]);
        }
    }
}
