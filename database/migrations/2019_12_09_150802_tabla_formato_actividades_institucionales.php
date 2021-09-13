<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaFormatoActividadesInstitucionales extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('Actividades_Institucionales', function($table) {
			$table->increments('Id_Actividad');
			$table->integer('Id_Promotor')->unsigned();
			$table->date('Fecha');
			$table->string('Nombre_Del_Evento');
			$table->string('Tipo');
			$table->string('Mecanicos');
			$table->string('Objetivo');
			$table->string('Empresa');
			$table->string('Encargado');
			$table->string('Telefono');
			$table->string('Punto_De_Encuentro');
			$table->time('Hora_Inicio');
			$table->time('Hora_Fin');
			$table->integer('Participantes')->unsigned();
			$table->integer('Apoyo_Mecanicos')->unsigned();
			$table->integer('Apoyo_Guardianes')->unsigned();
			$table->integer('Apoyo_Movilidad')->unsigned();
			$table->integer('Apoyo_Policias')->unsigned();
			$table->integer('Apoyo_Otros')->unsigned();
			$table->integer('Prestamos_Rin12')->unsigned();
			$table->integer('Prestamos_Rin16')->unsigned();
			$table->integer('Prestamos_Rin20')->unsigned();
			$table->integer('Prestamos_Rin26')->unsigned();
			$table->string('Recorrido')->nullable();
			$table->string('Direccion_Finalizacion')->nullable();
			$table->string('Tipo_De_Recorrido')->nullable();
			$table->integer('Kilometros_Recorridos')->unsigned();
			$table->string('RegistroEsquematicoRecorrido')->nullable();
			$table->string('Observaciones')->nullable();
			
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('Id_Promotor')->references('Id_Promotor')->on('Promotores');
		});
		
		Schema::create('Actividad_Evidencias', function($table) {
			$table->increments('Id_Evidencia');
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
		Schema::table('Actividad_Evidencias', function(Blueprint $table)
        {
            $table->dropForeign(['Id_Actividad']);
		});

		Schema::drop('Actividad_Evidencias');

		Schema::table('Actividades_Institucionales', function(Blueprint $table)
        {
            $table->dropForeign(['Id_Promotor']);
		});
		
        Schema::drop('Actividades_Institucionales');
    }
}
