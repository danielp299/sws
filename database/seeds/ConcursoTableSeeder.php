<?php

use Illuminate\Database\Seeder;

class ConcursoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('concursos')->truncate();

        DB::table('concursos')->insert([
        	'uid_concurso'=>'kkkk',
        	'fecha'=>'Tuesday',
        	'tipo'=>'fuego',
        	'evolucion'=> 2,
        	'exp' => 1
        ]);
    }
}
