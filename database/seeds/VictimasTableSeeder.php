<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VictimasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('victimas')->truncate();

        DB::table('victimas')->insert([
        	'uid_user'=>'mariana',
        	'uid_avatar'=>'zxcv',
        	'exp'=>76,
        	'evolucion'=>0
        ]);

        DB::table('victimas')->insert([
        	'uid_user'=>'carlota',
        	'uid_avatar'=>'asdf',
        	'exp'=>56,
        	'evolucion'=>0
        ]);

        DB::table('victimas')->insert([
        	'uid_user'=>'daniel',
        	'uid_avatar'=>'abcd',
        	'exp'=>768,
        	'evolucion'=>2
        ]);

        DB::table('victimas')->insert([
        	'uid_user'=>'alexander',
        	'uid_avatar'=>'zxcv',
        	'exp'=>76,
        	'evolucion'=>0
        ]);
    }
}
