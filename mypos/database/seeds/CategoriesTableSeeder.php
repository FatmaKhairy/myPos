<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$categories=['cars','phones'];
    		foreach ($categories as $category){
					\App\Category::create([
							'ar'=>['name'=>$category],
							'en'=>['name'=>$category],
					]);
				}

    }
}
