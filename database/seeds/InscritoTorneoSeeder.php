<?php

use Illuminate\Database\Seeder;

class InscritoTorneoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inscritos_torneos')->truncate();

        DB::table('inscritos_torneos')->insert([
        	'uid_user'=>'carlos',
        	'uid_torneo'=>'rtyu',
        	'uid_avatar'=>'qwerty',
        	'exp'=>50
        ]);

         DB::table('inscritos_torneos')->insert([
        	'uid_user'=>'marian',
        	'uid_torneo'=>'rtyu',
        	'uid_avatar'=>'qwdfgt',
        	'exp'=>987
        ]);

          DB::table('inscritos_torneos')->insert([
        	'uid_user'=>'stephanie',
        	'uid_torneo'=>'rtyu',
        	'uid_avatar'=>'abcd',
        	'exp'=>555
        ]);
    }
}
