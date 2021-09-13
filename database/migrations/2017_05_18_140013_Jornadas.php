<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Jornadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Jornadas', function(Blueprint $table)
        {
            $table->increments('Id_Jornada');
            $table->integer('Id_Promotor')->unsigned();
            $table->integer('Id_Parque')->unsigned();
            $table->date('Fecha');
            $table->string('Clima');
            $table->string('Nombre_Encargado');
            $table->text('Observaciones_Generales');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('Id_Promotor')->references('Id_Promotor')->on('Promotores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Jornadas', function(Blueprint $table)
        {
            $table->dropForeign(['Id_Promotor']);
        });

        Schema::drop('Jornadas');
    }
}
