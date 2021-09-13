<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaPromotoresEscenarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Promotor_Escenario', function($table) {
			$table->integer('Id_Promotor')->unsigned();
			$table->integer('Id_Escenario')->unsigned();

			$table->foreign('Id_Promotor')->references('Id_Promotor')->on('Promotores');
			$table->foreign('Id_Escenario')->references('Id_Escenario')->on('Escenarios');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Promotor_Escenario', function(Blueprint $table)
        {
            $table->dropForeign(['Id_Promotor']);
            $table->dropForeign(['Id_Escenario']);
		});

		Schema::drop('Promotor_Escenario');
    }
}
