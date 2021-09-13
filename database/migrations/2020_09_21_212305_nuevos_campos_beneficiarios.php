<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NuevosCamposBeneficiarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Beneficiarios', function($table)
        {
            $table->integer('Id_Localidad')->unsigned()->nullable()->after('Id_Discapacidad');
            $table->integer('Id_Upz')->unsigned()->nullable()->after('Id_Localidad');
            $table->integer('Id_Barrio')->unsigned()->nullable()->after('Id_Upz');
            $table->integer('Estrato')->unsigned()->nullable()->after('Id_Barrio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Beneficiarios', function($table)
        {
            $table->dropColumn('Id_Localidad');
            $table->dropColumn('Id_Upz');
            $table->dropColumn('Id_Barrio');
            $table->dropColumn('Estrato');
        });
    }
}
