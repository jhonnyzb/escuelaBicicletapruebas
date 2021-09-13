<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Usuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Usuarios', function(Blueprint $table)
        {
            $table->increments('Id_Usuario');
            $table->integer('Id_Jornada')->unsigned();
            $table->string('Nombre_Acudiente');
            $table->string('Email_Acudiente')->nullable();
            $table->string('Telefono_Acudiente')->nullable();
            $table->boolean('Acudiente_Es_Usuario')->nullable();
            $table->string('Nombre_Usuario');
            $table->string('Nombre_Tipo_Documento_Usuario')->nullable();
            $table->string('Documento_Usuario')->nullable();
            $table->string('Genero_Usuario')->nullable();
            $table->integer('Edad_Usuario');
            $table->string('CB_Usuario');
            $table->time('Hora_Inicio_Usuario');
            $table->time('Hora_Fin_Usuario');
            $table->string('Destreza_Inicial_Usuario');
            $table->string('Avance_Logrado_Usuario');
            $table->string('Observaciones_Usuario');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Usuarios');
    }
}
