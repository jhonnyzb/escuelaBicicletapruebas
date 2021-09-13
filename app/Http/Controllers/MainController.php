<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use App\Modulos\Parque\Parque;
use App\Modulos\Escuela\Jornada;
use App\Modulos\Escuela\Actividad;
use App\Modulos\Escuela\Escenario;
use App\Modulos\Escuela\Beneficiario;
use App\Modulos\Escuela\Asistencia;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller {

	protected $Usuario;
	protected $repositorio_personas;

	public function __construct(PersonaInterface $repositorio_personas) {
		if (isset($_SESSION['Usuario']))
			$this->Usuario = $_SESSION['Usuario'];

		$this->repositorio_personas = $repositorio_personas;
	}

	public function welcome() {
		$data = [
			'titulo' => 'Inicio',
			'seccion' => 'Inicio'
		];

		return view('welcome', $data);
	}

    public function reporte() {
        $datos = [
            'titulo' => 'Reporte general',
            'seccion' => 'Reporte general',
            'formulario' => ''
        ];

        return view('reporte', $datos);
	}
	
	public function reporte_general_2(){
		$datos = [
            'titulo' => 'Reporte general 2',
            'seccion' => 'Reporte general 2',
            'formulario' => ''
        ];

        return view('reporte_general', $datos);
	}

    public function fecha_reporte(Request $request) {
       return Datatables::of(DB::table('vista_reporte')->whereBetween('Fecha', [$request[0]['value'],$request[1]['value']]))->make(true);
	}
	
	public function reporte_general_consulta(Request $request){
		$resultados = Asistencia::with('beneficiario','promotor.persona','escenario')->whereBetween('Fecha', [$request->fechai, $request->fechaf])
                            ->OrderBy('Fecha')
                            ->get();


		if(count($resultados) > 0){
            Excel::load('public/plantillas/REPORTE.xlsx', function ($reader) use ($resultados){
                $reader->setActiveSheetIndex(0);
                $reader->sheet(0, function ($sheet) use ($resultados) {
					$fila = 2;
					$niveles = [
						0 => 'A - No sabe montar bicicleta',
						1 => 'B - Pedalea con ruedas de entrenamiento',
						2 => 'C - Camina con la bicicleta',
						3 => 'D - Se impulsa y mantiene el equilibrio por instantes',
						4 => 'E - Se impulsa y mantiene el equilibrio',
						5 => 'F - Pedalea con apoyo',
						6 => 'G - Pedalea y mantiene el equilibrio por instantes',
						7 => 'H - Maneja',
						8 => 'I - Maneja y adquiere otras habilidades sobre la bicicleta'
					];

                    foreach ($resultados as $resultado)
                    {
                        $sheet->setCellValue('A'.$fila, $resultado->escenario['Nombre']);
                        $sheet->setCellValue('B'.$fila, $resultado->promotor->persona['Primer_Nombre'].' '.$resultado->promotor->persona['Segundo_Nombre'].' '.$resultado->promotor->persona['Primer_Apellido'].' '.$resultado->promotor->persona['Segundo_Apellido']);
                        $sheet->setCellValue('C'.$fila, $resultado->beneficiario['Nombre']);
                        $sheet->setCellValue('D'.$fila, $resultado->Fecha);
                        $sheet->setCellValue('E'.$fila, str_pad($resultado->Hora, 2, '0', STR_PAD_LEFT).':00');
                        $sheet->setCellValue('F'.$fila, $resultado->Nivel_Destreza ? $niveles[$resultado->Nivel_Destreza] : '');
                        $fila++;
                    }
                });
            })->export('xlsx');// va tocar armar el excel de la otra forma ye eso toca ver si los otros sirven esos que uno hace todo, noc argar datos
        }else{

            $datos = [
                'status' => 'error'
            ];
        }
		
	}

    public function reporte_consolidado() {
    	return $this->view_reporte_consolidado(null);
    }

    public function reporte_consolidado_search(Request $request) {
    	$qb = Jornada::with('usuarios');

		if ($request->has('fechai')) {
    		$qb->where('fecha', '>=', $request->input('fechai'));
    	}

    	if ($request->has('fechaf')) {
    		$qb->where('fecha', '<=', $request->input('fechaf'));
    	}

	    $qb->orderBy('Fecha');
	    $jornadas = $qb->get();

	    //dd($jornadas);

	    $informe = [];



    	/*
    	$escenarios = Parque::with(['jornadas' => function($query) use ($request) {
    		$query->with('usuarios');
	    	if ($request->has('fechai')) {
	    		$query->where('fecha', '>=', $request->input('fechai'));
	    	}

	    	if ($request->has('fechaf')) {
	    		$query->where('fecha', '<=', $request->input('fechaf'));
	    	}

	    	$query->orderBy('Fecha');
    	}])->whereHas('jornadas', function($query) use ($request) {
    		$query->whereNull('deleted_at');
			if ($request->has('fechai')) {
	    		$query->where('fecha', '>=', $request->input('fechai'));
	    	}

	    	if ($request->has('fechaf')) {
	    		$query->where('fecha', '<=', $request->input('fechaf'));
	    	}
    	})->get();
    	*/

    	return $this->view_reporte_consolidado($escenarios);
    }

    public function reporte_actividades() {
        $datos = [
			'actividades' => session('actividades'),
            'titulo' => 'Reporte actividades',
            'seccion' => 'Reporte actividades'
        ];

        return view('reporte_actividades', $datos);
	}

    public function reporte_actividades_exportar(Request $request) {
		$request->flash();

		if($request->input('accion') == 'exportar') 
		{
			Excel::load('public/formatos/REPORTE_ACTIVIDADES_INSTITUCIONALES.xlsx', function ($file) use ($request) {
				$file->sheet(0, function ($sheet) use ($request) {
					$qb = Actividad::whereNull('deleted_at');

					$qb = $this->aplicarFiltro($qb, $request);

					$elementos = $qb->orderBy('Id_Actividad', 'DESC')
									->get();

					$row = 3;

					foreach($elementos as $elemento) {
						$registro = [
							$elemento->Fecha,
							$elemento->Nombre_Del_Evento,
							$elemento->Tipo,
							$elemento->Mecanicos,
							$elemento->Objetivo,
							$elemento->Empresa,
							$elemento->Encargado,
							$elemento->Telefono,
							$elemento->Punto_De_Encuentro,
							$elemento->Hora_Inicio,
							$elemento->Hora_Fin,
							$elemento->Participantes_Femenino,
							$elemento->Participantes_Masculino,
							$elemento->Participantes_Femenino + $elemento->Participantes_Masculino,
							$elemento->Apoyo_Mecanicos,
							$elemento->Apoyo_Guardianes,
							$elemento->Apoyo_Movilidad,
							$elemento->Apoyo_Policias,
							$elemento->Apoyo_Otros,
							$elemento->Prestamos_Rin26,
							$elemento->Prestamos_Rin20,
							$elemento->Prestamos_Rin16,
							$elemento->Prestamos_Rin12,
							$elemento->Recorrido,
							$elemento->Direccion_Finalizacion,
							$elemento->Tipo_De_Recorrido,
							$elemento->Kilometros_Recorridos
						];

						$sheet->row($row, $registro);
						$row++;
					}
				});
			})->export('xlsx');
		} else {
			$qb = Actividad::with('promotor.persona')->whereNull('deleted_at');

			$qb = $this->aplicarFiltro($qb, $request);

			$actividades = $qb->orderBy('Id_Actividad', 'DESC')
							->get();
			
			return redirect('/reporte_actividades')->with('actividades', $actividades);
		}
	}
	
	public function reporte_jornadas_exportar(Request $request, $id_jornada) {
		$jornada = Jornada::with('usuarios', 'escenario.localidad')->find($id_jornada);

		Excel::load('public/formatos/REPORTE_JORNADA.xlsx', function ($file) use ($jornada) {
			$file->sheet(0, function ($sheet) use ($jornada) {
				$row = 3;
				foreach($jornada->usuarios as $usuario) {

					$cb = '';

					switch($usuario->CB_Usuario)
					{
						case 'P.I':
							$cb = 'Primera infancia';
						break;
						case 'I':
							$cb = 'Infancia';
						break;
						case 'ADO':
							$cb = 'Adolescencia';
						break;
						case 'ADU':
							$cb = 'Adultez';
						break;
						case 'VE':
							$cb = 'Vejez';
						break;
						default:
							$cb = '';
					}

					$registro = [
						$usuario->Id_Usuario,
						$row - 2,
						$jornada->escenario->localidad['Localidad'],
						$jornada->escenario['Nombre'],
						$jornada['Fecha'],
						$jornada['Clima'],
						$jornada['Nombre_Encargado'],
						$jornada['Tipo'],
						$jornada['Observaciones_Generales'],
						$usuario['Documento_Acudiente'],
						$usuario['Nombre_Acudiente'],
						$usuario['Email_Acudiente'],
						$usuario['Telefono_Acudiente'],
						$usuario['Nombre_Usuario'],
						$usuario['Nombre_Tipo_Documento_Usuario'],
						$usuario['Documento_Usuario'],
						$usuario['Genero_Usuario'],
						$usuario['Edad_Usuario'],
						$cb,
						$usuario['Hora_Inicio_Usuario'],
						$usuario['Hora_Fin_Usuario'],
						$usuario['Destreza_Inicial_Usuario'],
						$usuario['Avance_Logrado_Usuario'],
						$usuario['Observaciones_Usuario'],
						$usuario['created_at']
					];

					$sheet->row($row, $registro);
					$row ++;
				}
			});
		})->export('xlsx');
	}

    private function view_reporte_consolidado($escenarios = null) {
    	$informe = is_null($escenarios) ? null : [];

    	if ($escenarios != null) {
    		foreach ($escenarios as $escenario) {
    			array_push($informe, [
    				'escenario' => $escenario,
    				'jornadas' => $escenario->jornadas->groupBy(function($item, $key) {
    					return Carbon::createFromFormat('Y-m-d', $item->Fecha)->format('Y-m');
    				})
    			]);
    		}

    		//dd($informe[0]);
    	}

    	$datos = [
            'titulo' => 'Reporte consolidado',
            'seccion' => 'Reporte consolidado',
            'datos' => $informe
        ];

        return view('reporte-consolidado', $datos);
    }

    public function index(Request $request) {
		//$fake_permissions = ['408520', '1', '1', '1', '1'];
		$fake_permissions = null;

		if ($request->has('vector_modulo') || $fake_permissions)
		{
			$vector = $request->has('vector_modulo') ? urldecode($request->input('vector_modulo')) : $fake_permissions;
			$user_array = is_array($vector) ? $vector : unserialize($vector);
			$permissions_array = $user_array;

			$permisos = [
				'administrar_promotores' => array_key_exists(1, $permissions_array) ? intval($permissions_array[1]) : 0,
				'administrar_jornadas' => array_key_exists(2, $permissions_array) ? intval($permissions_array[2]) : 0,
				'administrar_reportes' => array_key_exists(3, $permissions_array) ? intval($permissions_array[3]) : 0,
				'administrar_escenarios' => array_key_exists(4, $permissions_array) ? intval($permissions_array[4]) : 0
			];

			$_SESSION['Usuario'] = $user_array;
            $persona = $this->repositorio_personas->obtener($_SESSION['Usuario'][0]);

			$_SESSION['Usuario']['Roles'] = [];
			$_SESSION['Usuario']['Persona'] = $persona;
			$_SESSION['Usuario']['Permisos'] = $permisos;
			$this->Usuario = $_SESSION['Usuario'];
		} else {
			if (!isset($_SESSION['Usuario']))
				$_SESSION['Usuario'] = '';
		}

		if ($_SESSION['Usuario'] == '')
			return redirect()->away('http://www.idrd.gov.co/SIM/Presentacion/');

		return redirect('/welcome');
	}

	public function logout() {
		$_SESSION['Usuario'] = '';
		Session::set('Usuario', '');

		return redirect()->to('/');
    }
    
    private function aplicarFiltro($qb, $request)
	{
		if($request->input('desde'))
		{
			$qb->where('Fecha', '>=', $request->input('desde'));
		}

		if($request->input('hasta'))
		{
			$qb->where('Fecha', '<=', $request->input('hasta'));
		}

		return $qb;
	}
}
