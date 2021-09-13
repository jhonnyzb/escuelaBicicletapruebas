<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaAsistencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Asistencia', function($table) {
            $table->increments('Id_Asistencia');
			$table->integer('Id_Beneficiario')->unsigned();
			$table->integer('Id_Promotor')->unsigned();
			$table->integer('Id_Escenario')->unsigned();
            $table->date('Fecha');
            $table->integer('Hora');
            $table->string('Asistio')->nullable();
            $table->string('Nivel_Destreza')->nullable();
            
			$table->foreign('Id_Beneficiario')->references('Id_Beneficiario')->on('Beneficiarios');
			$table->foreign('Id_Promotor')->references('Id_Promotor')->on('Promotores');
			$table->foreign('Id_Escenario')->references('Id_Escenario')->on('Escenarios');
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
        Schema::table('Asistencia', function(Blueprint $table)
        {
            $table->dropForeign(['Id_Beneficiario']);
            $table->dropForeign(['Id_Promotor']);
            $table->dropForeign(['Id_Escenario']);
		});

		Schema::drop('Asistencia');
    }
}
