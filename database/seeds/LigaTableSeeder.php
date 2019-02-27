<?php

use Illuminate\Database\Seeder;

class LigaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ligas')->truncate();

        DB::table('ligas')->insert([
        	'uid_liga'=>'asdfg',
        	'uid_gym'=>'asdfg',
        	'uid_user'=>'carlos',
        	'puntos'=>34
        ]);

         DB::table('ligas')->insert([
        	'uid_liga'=>'asdfg',
        	'uid_gym'=>'asdfg',
        	'uid_user'=>'stephanie',
        	'puntos'=>344
        ]);

          DB::table('ligas')->insert([
        	'uid_liga'=>'asdfg',
        	'uid_gym'=>'asdfg',
        	'uid_user'=>'ana',
        	'puntos'=>234
        ]);

           DB::table('ligas')->insert([
        	'uid_liga'=>'asdfg',
        	'uid_gym'=>'asdfg',
        	'uid_user'=>'daniel',
        	'puntos'=>34567
        ]);
    }
}
