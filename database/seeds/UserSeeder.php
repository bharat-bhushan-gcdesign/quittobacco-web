<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert([
            [
    	        'id' =>1,
    	        'code'=>'xxxyyyzzz',
		        'name'=>'Admin',
		        'email'=>'who@gmail.com', 
		        'mobile'=>'1234567890',
		        'password'=>'$2y$10$rz9a801BveI7iFhsGpJBJu/g5sNZHcW5tjOZbIXXwL/V7x1xRlMOe', // whoapp@123
		        'fcm_token'=>'xxyyzz',
		        'role'=>1,
		        'gender'=>1,
		        'date_of_birth'=>'',
		        'otp'=>1111,
		        'status'=>1
    	    ]
    	]);
    }
}
