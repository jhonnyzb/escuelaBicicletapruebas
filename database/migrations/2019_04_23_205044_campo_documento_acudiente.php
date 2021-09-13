<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampoDocumentoAcudiente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Usuarios', function($table)
        {
            $table->string('Documento_Acudiente')->after('Id_Jornada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Usuarios', function($table)
        {
            $table->dropColumn('Documento_Acudiente');
        });
    }
}
