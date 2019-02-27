<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GimnasiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gimnasios')->truncate();

        DB::table('gimnasios')->insert([
        	'uid_gym'=>'ghjk',
        	'description'=>'Gimanasio de agua',
        	'medal'=>'oro'
        ]);

         DB::table('gimnasios')->insert([
        	'uid_gym'=>'tyuio',
        	'description'=>'Gimanasio de fuego',
        	'medal'=>'bronce'
        ]);

          DB::table('gimnasios')->insert([
        	'uid_gym'=>'iokjhg',
        	'description'=>'Gimanasio de tierra',
        	'medal'=>'oro'
        ]);

           DB::table('gimnasios')->insert([
        	'uid_gym'=>'asdfg',
        	'description'=>'Gimanasio de aire',
        	'medal'=>'plata'
        ]);
    }
}
