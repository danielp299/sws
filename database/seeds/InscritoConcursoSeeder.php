<?php

use Illuminate\Database\Seeder;

class InscritoConcursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inscrito_concursos')->truncate();

        DB::table('inscrito_concursos')->insert([
        	'uid_user'=>'stephanie',
        	'id_avatar'=>2,
        	'uid_concurso'=>'kkkk',
        	'exp'=> 768
        ]);
        DB::table('inscrito_concursos')->insert([
        	'uid_user'=>'carlos',
        	'id_avatar'=>1,
        	'uid_concurso'=>'kkkk',
        	'exp'=> 50
        ]);
        DB::table('inscrito_concursos')->insert([
            'uid_user'=>'ana',
            'id_avatar'=>2,
            'uid_concurso'=>'kkkk',
            'exp'=> 768
        ]);

         DB::table('inscrito_concursos')->insert([
            'uid_user'=>'magaly',
            'id_avatar'=>5,
            'uid_concurso'=>'kkkk',
            'exp'=> 56
        ]);
         DB::table('inscrito_concursos')->insert([
            'uid_user'=>'juan',
            'id_avatar'=>6,
            'uid_concurso'=>'kkkk',
            'exp'=> 452
        ]);
    }
}
