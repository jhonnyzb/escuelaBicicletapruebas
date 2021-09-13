<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampoCantidadesXGeneroActividadesInstitucionales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Actividades_Institucionales', function($table)
        {
            $table->integer('Participantes_Femenino')->unsigned()->after('Hora_Fin');
            $table->integer('Participantes_Masculino')->unsigned()->after('Participantes_Femenino');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Actividades_Institucionales', function($table)
        {
            $table->dropColumn('Participantes_Femenino');
            $table->dropColumn('Participantes_Masculino');
        });
    }
}
