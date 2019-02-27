<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionGlobalJuego2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion_global_juego2s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->float('probabilidad_evolucion');
            $table->float('probabilidad_bono');
            $table->float('efecto_ventaja_evolucion');
            $table->float('efecto_ventaja_elemento');
            $table->float('efecto_ventaja_bono');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracion_global_juego2s');
    }
}
