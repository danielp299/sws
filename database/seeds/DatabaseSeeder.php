<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()

    {
      
    	$this->call(AvatarTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(GimnasiosTableSeeder::class);
        $this->call(VictimasTableSeeder::class);
        $this->call(LigaTableSeeder::class);
        $this->call(ProgresoLigaTableSeeder::class);
        $this->call(TorneoTableSeeder::class);
        $this->call(MedallaTableSeeder::class);
        $this->call(InscritoTorneoSeeder::class);
        $this->call(ReglaTableSeeder::class);
        $this->call(ConcursoTableSeeder::class);
        $this->call(InscritoConcursoSeeder::class);

        
      //  factory(App\InscritosTorneo::class, 10)->create();
    }
}
