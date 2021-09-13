<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NuevosCamposEscenario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Escenarios', function($table)
        {
            $table->integer('Habilitado')->unsigned()->nullable();
            $table->integer('Hora_Inicio')->unsigned()->nullable();
            $table->integer('Hora_Fin')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Escenarios', function($table)
        {
            $table->dropColumn('Habilitado');
            $table->dropColumn('Hora_Inicio');
            $table->dropColumn('Hora_Fin');
        });
    }
}
