<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
				$user=\App\User::create([
						'first_name'=>'Super',
						'last_name'=>'Admin',
						'email'=>'superAdmin@app.com',
						'password'=>bcrypt('12345678'),

				]);
				$user->attachRole('super_admin');
    }
}
