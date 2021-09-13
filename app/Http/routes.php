<?php
session_set_cookie_params(5000000000, "/");
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
date_default_timezone_set('America/Bogota');

// if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
//     error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// }
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/personas', '\Idrd\Usuarios\Controllers\PersonaController@index');
Route::get('/personas/service/obtener/{id}', '\Idrd\Usuarios\Controllers\PersonaController@obtener');
Route::get('/personas/service/buscar/{key}', '\Idrd\Usuarios\Controllers\PersonaController@buscar');
Route::get('/personas/service/ciudad/{id_pais}', '\Idrd\Usuarios\Controllers\LocalizacionController@buscarCiudades');
Route::post('/personas/service/procesar/', '\Idrd\Usuarios\Controllers\PersonaController@procesar');
Route::post('/upz', function() { $upzs = Idrd\Parques\Repo\Upz::where('IdLocalidad', request()->input('Id_Localidad'))->get(); return response()->json($upzs); });
Route::post('/barrios', function() { 
    $upz =  Idrd\Parques\Repo\Upz::where('Id_Upz', request()->input('Id_Upz'))->first();
    $barrios = Idrd\Parques\Repo\Barrio::where('CodUpz', $upz->cod_upz)->get(); return response()->json($barrios); 
});


//ruta pre inscripcion

Route::group(['middleware' => ['web']], function () {
    Route::any('/', 'MainController@index');
    Route::get('/welcome', 'MainController@welcome');
    Route::any('/logout', 'MainController@logout');
    Route::get('/certificado', 'CertificadoController@index');
    Route::post('/certificado', 'CertificadoController@generar');
    // Route::get('/reservar', 'BeneficiarioController@reservar');
    // Route::get('/reservar', 'BeneficiarioController@reservar');
    Route::get('/miPerfil/{documento?}', 'BeneficiarioController@perfil');
    // Route::get('/inscripcion', 'BeneficiarioController@inscripcion');
    Route::post('/consultar_beneficiario', 'BeneficiarioController@consultar_beneficiario');
    Route::post('/inscripcion_beneficiarios', 'BeneficiarioController@inscripcion_beneficiarios');
    Route::get('/reservar_clase/{cedula?}', 'BeneficiarioController@reservar_clase');
    Route::get('/cancelar_clase/{cedula?}', 'BeneficiarioController@cancelar_clase');
    Route::get('/eliminar_clase/{asistencia?}', 'BeneficiarioController@eliminar_clase');
    
    
    Route::post('/consultar_promotor', 'EscenarioController@consultar_promotor');
    Route::post('/consultar_disponibilidad', 'BeneficiarioController@consultar_disponibilidad');
    Route::post('/guardar_clases', 'BeneficiarioController@guardar_clases');
});

//rutas con filtro de autenticación
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::any('/reporte_asistencia', 'MainController@reporte');
    Route::any('/fecha_reporte', 'MainController@fecha_reporte');
    Route::get('/reporte_consolidado', 'MainController@reporte_consolidado');
    Route::post('/reporte_consolidado', 'MainController@reporte_consolidado_search');
    Route::get('/reporte_actividades', 'MainController@reporte_actividades');
    Route::post('/reporte_actividades', 'MainController@reporte_actividades_exportar');
    Route::get('/jornadas/{id_jornada}/exportar', 'MainController@reporte_jornadas_exportar');
    Route::any('/reporte_general_2', 'MainController@reporte_general_2');
    Route::post('/reporte_general_2', 'MainController@reporte_general_consulta');

    
    

	Route::get('/promotores', 'PromotorController@index');
	Route::get('/promotores/crear', 'PromotorController@crear');
    Route::get('/promotores/{id}/editar', 'PromotorController@editar');
    Route::get('/promotores/{id}/eliminar', 'PromotorController@eliminar');
    Route::post('/promotores/procesar', 'PromotorController@procesar');
    Route::get('/programacion_promotores', 'PromotorController@programacion_promotores');
    Route::post('/programacion_promotores_consulta', 'PromotorController@programacion_promotores_consulta');


    Route::get('/escenarios', 'EscenarioController@index');
    Route::get('/escenarios/crear', 'EscenarioController@crear');
    Route::get('/escenarios/{id}/editar', 'EscenarioController@editar');
    Route::get('/escenarios/{id}/eliminar', 'EscenarioController@eliminar');
    Route::post('/escenarios/procesar', 'EscenarioController@procesar');
    Route::post('/escenarios/cancelar', 'EscenarioController@cancelar');

    Route::get('/asignacion', 'EscenarioController@asignar');
    Route::post('/guardar_asignacion', 'EscenarioController@guardar_asignacion');
    Route::post('/consultar_escenarios', 'EscenarioController@consultar_escenarios');
    Route::post('/consultar_promotores', 'EscenarioController@consultar_promotores');

	Route::any('/jornadas', 'JornadaController@index');
	Route::any('/jornadas/formulario/{id_jornada?}', 'JornadaController@formulario');
	Route::post('/jornadas/procesar', 'JornadaController@procesar');
	Route::post('/jornadas/consultarUsuario', 'JornadaController@consultarUsuario');
    Route::get('/jornadas/{id_jornada}/eliminar', 'JornadaController@eliminar');

    Route::any('/actividades', 'ActividadController@index');
    Route::any('/actividades/formulario/{id_actividad?}', 'ActividadController@formulario');
    Route::post('/actividades/procesar', 'ActividadController@procesar');
    Route::get('/evidencias/{id_evidencia}/eliminar', 'ActividadController@eliminarEvidencia');
    Route::get('/registros/{id_registro}/eliminar', 'ActividadController@eliminarRegistro');
    Route::get('/actividades/{id_actividad}/eliminar', 'ActividadController@eliminar');
    
    Route::get('/asistencias', 'BeneficiarioController@listar_clases');
    Route::post('/consultar_clases', 'BeneficiarioController@consultar_clases');
    Route::post('/guardar_asistencia', 'BeneficiarioController@guardar_asistencia');
    
});

Route::get('/panel', 'PanelController@index');
Route::post('/panel/consulta', 'PanelController@procesos');
