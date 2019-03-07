<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGimnasiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gimnasios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid_gym')->unique();
            $table->string('description');
            $table->string('medal');
            $table->string('leader')->default('none');
            $table->string('mascota')->default('none');
            $table->string('points')->default('0');
            $table->string('members')->default('0');
            $table->string('ranking')->default('999');
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
        Schema::dropIfExists('gimnasios');
    }
}
