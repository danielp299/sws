<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvatarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('avatar')->truncate();
    	
        DB::table('avatar')->insert([
        	'uid_avatar'=>'qwerty',
        	'exp'=>50
        ]);

        DB::table('avatar')->insert([
        	'uid_avatar'=>'abcd',
        	'exp'=>768
        ]);

        DB::table('avatar')->insert([
        	'uid_avatar'=>'zxcv',
        	'exp'=>76
        ]);

        DB::table('avatar')->insert([
        	'uid_avatar'=>'asdf',
        	'exp'=>56
        ]);
         DB::table('avatar')->insert([
            'uid_avatar'=>'qty',
            'exp'=>56
        ]);
          DB::table('avatar')->insert([
            'uid_avatar'=>'rt5y',
            'exp'=>452
        ]);
    }
}
