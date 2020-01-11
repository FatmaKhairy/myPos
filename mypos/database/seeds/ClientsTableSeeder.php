<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
				\App\client::create([
						'name'=>'Fatma Khairy',
						'phone'=>['011','012'],
						'address'=>'Egypt,Alex',
				]);
    }
}
