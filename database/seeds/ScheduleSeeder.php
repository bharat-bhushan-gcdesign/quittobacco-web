<?php

use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedules')->delete();
        
        DB::table('schedules')->insert([
            [
    	        'id' =>1,
    	        'for'=>'Every Minute',
    	        'method'=>'everyMinute()',
    	        'description'=>'everyMinute',
                'status'=>1
    	        
    	    ],[
    	        'id' =>2,
    	        'for'=>'Daily',
    	        'method'=>'daily()',
    	        'description'=>'daily',
                'status'=>1
                
    	    ],

    	]);
    }
}
