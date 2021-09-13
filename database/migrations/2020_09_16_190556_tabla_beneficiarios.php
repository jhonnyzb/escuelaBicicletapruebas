<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaBeneficiarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Beneficiarios', function($table) {
            $table->increments('Id_Beneficiario');
            $table->string('Nombre');
            $table->integer('Id_Tipo_Documento')->unsigned();
            $table->integer('Id_Genero')->unsigned();
            $table->integer('Id_Grupo_Poblacional')->unsigned();
            $table->integer('Id_Discapacidad')->unsigned()->nullable();
            $table->string('Documento');
            $table->string('Correo');
            $table->string('Telefono');
            $table->date('Fecha_Nacimiento');
            $table->string('Nombre_Acudiente')->nullable();
            $table->integer('Id_Tipo_Documento_Acudiente')->unsigned()->nullable();
            $table->string('Documento_Acudiente')->nullable();
            $table->string('Telefono_Acudiente')->nullable();
            $table->string('Correo_Acudiente')->nullable();
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
        Schema::drop('Beneficiarios');
    }
}
