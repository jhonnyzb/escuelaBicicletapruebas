<?php

use Illuminate\Database\Seeder;

class EsceneriosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Escenarios')->insert([
            [
  	        	'Id_parque' => '8585',
  	        	'Id_Localidad' => '4',
  	        	'Nombre' => 'SAN CRISTOBAL'
  	        ],
      			[
      				'Id_parque' => '9478',
      				'Id_Localidad' => '6',
      				'Nombre' => 'EL TUNAL'
      			],
      			[
      				'Id_parque' => '9936',
      				'Id_Localidad' => '8',
      				'Nombre' => 'CAYETANO CAÑIZARES'
      			],
      			[
      				'Id_parque' => '9989',
      				'Id_Localidad' => '8',
      				'Nombre' => 'TIMIZA'
      			],
      			[
      				'Id_parque' => '10721',
      				'Id_Localidad' => '10',
      				'Nombre' => 'SAN ANDRES'
      			],
      			[
      				'Id_parque' => '10765',
      				'Id_Localidad' => '10',
      				'Nombre' => 'SIMON BOLIVAR ( SECTOR UNIDAD DEPORTIVA EL SALITRE )'
      			],
      			[
      				'Id_parque' => '15431',
      				'Id_Localidad' => '12',
      				'Nombre' => 'SIMON BOLIVAR ( SECTOR PARQUE DEPORTIVO EL SALITRE )'
      			],
      			[
      				'Id_parque' => '15565',
      				'Id_Localidad' => '13',
      				'Nombre' => 'SIMON BOLIVAR ( SECTOR CENTRAL )'
      			]
        ]);

        DB::table('Jornadas')->where('Id_Parque', '8585')->update(['Id_Parque' => '1']);
        DB::table('Jornadas')->where('Id_Parque', '9478')->update(['Id_Parque' => '2']);
        DB::table('Jornadas')->where('Id_Parque', '9936')->update(['Id_Parque' => '3']);
        DB::table('Jornadas')->where('Id_Parque', '9989')->update(['Id_Parque' => '4']);
        DB::table('Jornadas')->where('Id_Parque', '10721')->update(['Id_Parque' => '5']);
        DB::table('Jornadas')->where('Id_Parque', '10765')->update(['Id_Parque' => '6']);
        DB::table('Jornadas')->where('Id_Parque', '15431')->update(['Id_Parque' => '7']);
        DB::table('Jornadas')->where('Id_Parque', '15565')->update(['Id_Parque' => '8']);
    }
}
