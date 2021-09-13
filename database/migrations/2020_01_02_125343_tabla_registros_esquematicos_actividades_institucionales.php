<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaRegistrosEsquematicosActividadesInstitucionales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Actividad_Registros', function($table) {
			$table->increments('Id_Registro');
			$table->integer('Id_Actividad')->unsigned();
			$table->string('Archivo');
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('Id_Actividad')->references('Id_Actividad')->on('Actividades_Institucionales');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Actividad_Registros', function(Blueprint $table)
        {
            $table->dropForeign(['Id_Actividad']);
		});

		Schema::drop('Actividad_Registros');
    }
}
