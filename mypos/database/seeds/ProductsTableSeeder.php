<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			\App\product::create([
						'category_id'=>2,
						'ar'=>['name'=>'اي فون','description'=>'desc'],
					  'en'=>['name'=>'Iphone','description'=>'desc'],
						'purchase_price'=>150,
						'sales_price'=>200.56,
						'stock'=>10,
				]);
    	$products=[ 'BMW','hamar'];
    		foreach ($products as $product){
						\App\product::create([
								'category_id'=>1,
								'en'=>['name'=>$product,'description'=>$product.'desc'],
								'ar'=>['name'=>$product,'description'=>$product.'desc'],
								'purchase_price'=>150,
								'sales_price'=>200,
								'stock'=>10,
						]);
         }

}
}
