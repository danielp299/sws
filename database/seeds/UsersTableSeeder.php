<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::table('users')->truncate();
    	
        DB::table('users')->insert([
        	'uid_user'=>'carlos',
        	'uid_avatar'=>'qwerty',
        	'exp'=>50
        ]);
        DB::table('users')->insert([
            'uid_user'=>'ana',
            'uid_avatar'=>'abcd',
            'exp'=>456
        ]);
        DB::table('users')->insert([
            'uid_user'=>'marian',
            'uid_avatar'=>'qwdfgt',
            'exp'=>987
        ]);
        DB::table('users')->insert([
            'uid_user'=>'luis',
            'uid_avatar'=>'yutrf',
            'exp'=>23
        ]);
        DB::table('users')->insert([
            'uid_user'=>'juan',
            'uid_avatar'=>'rt5y',
            'exp'=>452
        ]);
        DB::table('users')->insert([
            'uid_user'=>'stephanie',
            'uid_avatar'=>'abcd',
            'exp'=>555
        ]);
        DB::table('users')->insert([
            'uid_user'=>'daniel',
            'uid_avatar'=>'qwe5ty',
            'exp'=>342
        ]);
        DB::table('users')->insert([
            'uid_user'=>'alexande',
            'uid_avatar'=>'cvbgf',
            'exp'=>3456
        ]);
        DB::table('users')->insert([
            'uid_user'=>'karen',
            'uid_avatar'=>'qrty',
            'exp'=>123
        ]);
        DB::table('users')->insert([
            'uid_user'=>'magaly',
            'uid_avatar'=>'qty',
            'exp'=>56
        ]);
    }
}
