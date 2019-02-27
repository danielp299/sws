<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgresoLigasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progreso_ligas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid_liga_oponente');
            $table->string('uid_liga')->nullable();
            $table->string('uid_user');
            $table->integer('victorias');
            $table->integer('derrotas');
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
        Schema::dropIfExists('progreso_ligas');
    }
}
