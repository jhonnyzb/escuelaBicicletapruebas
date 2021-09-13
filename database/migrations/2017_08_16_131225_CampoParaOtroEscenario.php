<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampoParaOtroEscenario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Jornadas', function($table)
        {
            $table->string('Otro')->after('Id_Parque');
            $table->integer('Id_Localidad')->unsigned()->after('Otro');
            $table->string('Tipo')->after('Id_Localidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Jornadas', function($table)
        {
            $table->dropColumn('Tipo');
            $table->dropColumn('Id_Localidad');
            $table->dropColumn('Otro');
        });
    }
}
