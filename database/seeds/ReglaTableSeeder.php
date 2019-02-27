<?php

use Illuminate\Database\Seeder;

class ReglaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reglas')->truncate();

        DB::table('reglas')->insert([
        	'tipo'=>'planta',
        	'evolucion'=>1
        ]);
        DB::table('reglas')->insert([
        	'tipo'=>'planta',
        	'evolucion'=>2
        ]);
        DB::table('reglas')->insert([
        	'tipo'=>'planta',
        	'evolucion'=>3
        ]);
        DB::table('reglas')->insert([
        	'tipo'=>'fuego',
        	'evolucion'=>1
        ]);
        DB::table('reglas')->insert([
        	'tipo'=>'fuego',
        	'evolucion'=>2
        ]);
        DB::table('reglas')->insert([
        	'tipo'=>'fuego',
        	'evolucion'=>3
        ]);
        DB::table('reglas')->insert([
        	'tipo'=>'agua',
        	'evolucion'=>1
        ]);
        DB::table('reglas')->insert([
        	'tipo'=>'agua',
        	'evolucion'=>2
        ]);
        DB::table('reglas')->insert([
        	'tipo'=>'agua',
        	'evolucion'=>3
        ]);
    }
}
