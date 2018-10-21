<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ImageTableSeeder extends Seeder
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
        	['path' => 'images/comments/test1.jpg', 'comment_id' => 11],
        	['path' => 'images/comments/test2.jpg', 'comment_id' => 13],
        	['path' => 'images/comments/test3.jpg', 'comment_id' => 13]
        ]);
    }
}
