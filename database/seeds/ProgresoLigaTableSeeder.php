<?php

use Illuminate\Database\Seeder;

class ProgresoLigaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('progreso_ligas')->truncate();

        DB::table('progreso_ligas')->insert([
        	'uid_liga'=>null,
        	'uid_liga_oponente'=>'asdfg',
        	'uid_user'=>'marian',
        	'victorias'=>0,
        	'derrotas'=>0
        ]);
    }
}
