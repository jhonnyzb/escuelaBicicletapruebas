<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaEscenarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Escenarios', function($table) {
            $table->increments('Id_Escenario');
            $table->integer('Id_Parque')->unsigned()->nullable();
            $table->integer('Id_Localidad')->unsigned()->nullable();
            $table->string('Nombre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Escenarios');
    }
}
