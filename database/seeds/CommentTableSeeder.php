<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('comments')->insert([
        	['content' => 'comment 1', 'location' => 'Ha Noi, Viet Nam', 'user_id' => 1, 
        	'plan_id' => 1],
        	['content' => 'comment child 1', 'location' => 'Ha Noi1, Viet Nam', 'user_id' => 2, 
        	'plan_id' => 1],
        	['content' => 'comment child 2', 'location' => 'Ha Noi2, Viet Nam', 'user_id' => 3, 
        	'plan_id' => 1],
        	['content' => 'comment 2', 'location' => 'Ha Noi2, Viet Nam', 'user_id' => 4, 
        	'plan_id' => 1],
        	['content' => 'comment 3', 'location' => 'Ha Noi, Viet Nam', 'user_id' => 3, 
        	'plan_id' => 1]
        ]);
    }
}
