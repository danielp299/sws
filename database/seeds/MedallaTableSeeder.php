<?php

use Illuminate\Database\Seeder;

class MedallaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medallas')->truncate();

        DB::table('medallas')->insert([
        	'uid_user'=>'marian',
        	'uid_gym'=>'asdfg'
        	
        ]);
        DB::table('medallas')->insert([
        	'uid_user'=>'marian',
        	'uid_gym'=>'ghjk'
        	
        ]);
    }
}
