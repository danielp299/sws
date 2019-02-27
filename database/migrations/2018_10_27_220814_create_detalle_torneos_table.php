<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleTorneosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_torneos', function (Blueprint $table) {
            $table->string('uid_torneo');
            $table->string('uid_user');
            $table->string('uid_oponente');
            $table->string('ganador');
            $table->boolean('evolucionA');
            $table->boolean('evolucionB');
            $table->boolean('boosterA');
            $table->boolean('boosterB');
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
        Schema::dropIfExists('detalle_torneos');
    }
}
