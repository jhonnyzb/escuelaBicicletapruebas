<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PanelController extends Controller
{
	function index() {
		$procesos_anio = DB::select('SELECT YEAR(created_at) as x, count(Documento_Usuario) as y FROM Usuarios GROUP BY YEAR(created_at)', []);
		$aprendieron_a_montar = DB::select('SELECT YEAR(created_at) as x, count(DISTINCT Documento_Usuario) as y FROM Usuarios WHERE Avance_Logrado_Usuario in (?, ?) GROUP BY YEAR(created_at)', ['H', 'I']);
		$hombres_y_mujeres = DB::select('SELECT count( DISTINCT CASE WHEN Genero_Usuario = ? THEN Documento_Usuario END ) AS Hombres, count( DISTINCT CASE WHEN Genero_Usuario = ? THEN Documento_Usuario END ) AS Mujeres FROM Usuarios', ['M', 'F']);
		$ciclo_biologico = DB::select('SELECT CASE WHEN CB_Usuario = "P.I" THEN "PRIMERA INFANCIA" WHEN CB_Usuario = "I" THEN "INFANCIA" WHEN CB_Usuario = "ADO" THEN "ADOLESCENCIA" WHEN CB_Usuario = "ADU" THEN "ADULTEZ" WHEN CB_Usuario = "VE" THEN "VEJEZ" END AS x, COUNT(DISTINCT Documento_Usuario) as y FROM Usuarios GROUP BY CB_Usuario');

		$data = [
			'titulo' => 'Inicio',
			'seccion' => 'Inicio',
			'procesos_anio' => $procesos_anio,
			'aprendieron_a_montar' => $aprendieron_a_montar,
			'hombres_y_mujeres' => $hombres_y_mujeres[0],
			'ciclo_biologico' => $ciclo_biologico
		];

		return view('panel', $data);
	}

	function procesos(Request $request) {
		$fecha_inicio = $request->input('fecha_inicio', date('Y-m-d'));
		$fecha_fin = $request->input('fecha_fin', date('Y-m-d'));

		$procesos = DB::select('SELECT COUNT(Documento_Usuario) as total FROM Usuarios u JOIN Jornadas j ON u.Id_Jornada = j.Id_Jornada WHERE j.Fecha BETWEEN ? AND ?', [$fecha_inicio, $fecha_fin]);
		$indicadores_de_aprendizaje = DB::select('SELECT CASE WHEN u.Avance_Logrado_Usuario = "A" THEN "No sabe montar bicicleta" WHEN u.Avance_Logrado_Usuario = "B" THEN "Pedalea con ruedas de entrenamiento" WHEN u.Avance_Logrado_Usuario = "C" THEN "Camina con la bicicleta" WHEN u.Avance_Logrado_Usuario = "D" THEN "Se impulsa y mantiene el equilibrio por instantes" WHEN u.Avance_Logrado_Usuario = "E" THEN "Se impulsa y mantiene el equilibrio"  WHEN u.Avance_Logrado_Usuario = "F" THEN "Pedalea con apoyo" WHEN u.Avance_Logrado_Usuario = "G" THEN "Pedalea y mantiene el equilibrio por instantes" WHEN u.Avance_Logrado_Usuario = "H" THEN "Maneja" WHEN u.Avance_Logrado_Usuario = "I" THEN "Maneja y adquiere otras habilidades sobre la bicicleta" END as avance, COUNT(DISTINCT Documento_Usuario) as total FROM Usuarios u JOIN Jornadas j ON u.Id_Jornada = j.Id_Jornada WHERE j.Fecha BETWEEN ? AND ? AND u.Avance_Logrado_Usuario <> "" GROUP BY u.Avance_Logrado_Usuario', [$fecha_inicio, $fecha_fin]);
		$hombres_y_mujeres = DB::select('SELECT count( DISTINCT CASE WHEN Genero_Usuario = ? THEN Documento_Usuario END ) AS Hombres, count( DISTINCT CASE WHEN Genero_Usuario = ? THEN Documento_Usuario END ) AS Mujeres FROM Usuarios u JOIN Jornadas j ON u.Id_Jornada = j.Id_Jornada WHERE j.Fecha BETWEEN ? AND ?', ['M', 'F', $fecha_inicio, $fecha_fin]);
		$tipos_de_actividades = DB::select('SELECT j.Tipo, COUNT(DISTINCT Documento_Usuario) as total FROM Usuarios u JOIN Jornadas j ON u.Id_Jornada = j.Id_Jornada WHERE j.Fecha BETWEEN ? AND ? GROUP BY j.Tipo', [$fecha_inicio, $fecha_fin]);

		return response()->json([
			'procesos' => $procesos[0],
			'indicadores_de_aprendizaje' => $indicadores_de_aprendizaje,
			'hombres_y_mujeres' => $hombres_y_mujeres[0],
			'tipos_de_actividades' => $tipos_de_actividades
		]);
	}
}