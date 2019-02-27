<?php

use Illuminate\Database\Seeder;

class TorneoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('torneos')->truncate();

        DB::table('torneos')->insert([
        	'uid_torneo'=>'rtyu',
        	'medallas'=>1,
        	'fecha'=>'Tuesday'
        ]);
    }
}
