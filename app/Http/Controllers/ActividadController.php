<?php

namespace App\Http\Controllers;

use App\Modulos\Escuela\Usuario;
use Illuminate\Http\Request;
use App\Modulos\Escuela\Promotor;
use App\Modulos\Escuela\Jornada;
use App\Modulos\Escuela\Actividad;
use App\Modulos\Escuela\ActividadEvidencias;
use App\Modulos\Escuela\ActividadRegistros;
use App\Modulos\Escuela\Escenario;
use Idrd\Usuarios\Repo\Documento;
use Idrd\Usuarios\Repo\Pais;
use Idrd\Usuarios\Repo\Etnia;
use Idrd\Parques\Repo\Localidad;
use App\Http\Requests\GuardarActividad;

class ActividadController extends Controller
{
	private $promotor;

    public function __construct()
	{
		if (isset($_SESSION['Usuario']))
			$this->usuario = $_SESSION['Usuario'];

		$this->promotor = Promotor::with('persona')
									->where('Id_Persona', $this->usuario[0])
									->first();
	}

    public function index(Request $request)
    {
    	$request->flash();

		if ($request->isMethod('get'))
		{
			$qb = null;
			$elementos = $qb;
		} else {
			$qb = Actividad::where('Id_Promotor', $this->promotor['Id_Promotor']);

			$qb = $this->aplicarFiltro($qb, $request);

			$elementos = $qb->whereNull('deleted_at')
							->orderBy('Id_Actividad', 'DESC')
							->get();
		}

		$lista = [
	        'elementos' => $elementos,
	        'status' => session('status')
		];

		$datos = [
			'titulo' => 'Actividades promotor',
			'seccion' => 'Buscar actividades',
			'lista'	=> view('idrd.actividades.lista', $lista)
		];

		return view('list', $datos);
    }

    public function formulario(Request $request, $id_actividad = 0)
    {
    	$actividad = null;

    	if ($id_actividad)
    		$actividad = Actividad::with('evidencias')->find($id_actividad);

    	$formulario = [
			'actividad' => $actividad,
			'promotor' => $this->promotor,
	        'status' => session('status')
		];

		//dd($formulario);

		$datos = [
			'titulo' => 'Crear ó editar actividades',
			'seccion' => 'Crear actividades',
			'formulario' => view('idrd.actividades.formulario', $formulario)
		];

		return view('form', $datos);
    }

    public function eliminar(Request $request, $id_actividad) 
    {
        $actividad = Actividad::with('evidencias')->find($id_actividad);
        $actividad->delete();

        return redirect('/actividades');
    }

    public function eliminarEvidencia(Request $request, $id_evidencia = 0) {
        $evidencia = ActividadEvidencias::find($id_evidencia);
        $id_actividad = $evidencia['Id_Actividad'];
        unlink(public_path('evidencias').'/'.$evidencia['Archivo']);

        $evidencia->delete();
        return redirect('/actividades/formulario/'.$id_actividad)->with(['status' => 'success']);
	}
	
	public function eliminarRegistro(Request $request, $id_registro = 0) {
		$registro = ActividadRegistros::find($id_registro);
        $id_actividad = $registro['Id_Actividad'];
        unlink(public_path('registros').'/'.$registro['Archivo']);

        $registro->delete();
        return redirect('/actividades/formulario/'.$id_actividad)->with(['status' => 'success']);
	}

    public function procesar(GuardarActividad $request)
    {
    	if($request->input('Id_Actividad') == '0')
    		$actividad = new Actividad;
    	else
    		$actividad = Actividad::find($request->input('Id_Actividad'));

            $actividad->Id_Promotor = $request->input('Id_Promotor');
            $actividad->Fecha = $request->input('Fecha');
            $actividad->Nombre_Del_Evento = $request->input('Nombre_Del_Evento');
            $actividad->Tipo = $request->input('Tipo');
            $actividad->Mecanicos = $request->input('Mecanicos');
            $actividad->Objetivo = $request->input('Objetivo');
            $actividad->Empresa = $request->input('Empresa');
            $actividad->Encargado = $request->input('Encargado');
            $actividad->Telefono = $request->input('Telefono');
            $actividad->Punto_De_Encuentro = $request->input('Punto_De_Encuentro');
            $actividad->Hora_Inicio = $request->input('Hora_Inicio');
            $actividad->Hora_Fin = $request->input('Hora_Fin');
            $actividad->Participantes_Femenino = $request->input('Participantes_Femenino');
            $actividad->Participantes_Masculino = $request->input('Participantes_Masculino');
            $actividad->Apoyo_Mecanicos = $request->input('Apoyo_Mecanicos');
            $actividad->Apoyo_Guardianes = $request->input('Apoyo_Guardianes');
            $actividad->Apoyo_Movilidad = $request->input('Apoyo_Movilidad');
            $actividad->Apoyo_Policias = $request->input('Apoyo_Policias');
            $actividad->Apoyo_Otros = $request->input('Apoyo_Otros');
            $actividad->Prestamos_Rin12 = $request->input('Prestamos_Rin12');
            $actividad->Prestamos_Rin16 = $request->input('Prestamos_Rin16');
            $actividad->Prestamos_Rin20 = $request->input('Prestamos_Rin20');
            $actividad->Prestamos_Rin26 = $request->input('Prestamos_Rin26');
            $actividad->Recorrido = $request->input('Recorrido');
            $actividad->Direccion_Finalizacion = $request->input('Direccion_Finalizacion');
            $actividad->Kilometros_Recorridos = $request->input('Kilometros_Recorridos');
            $actividad->Tipo_De_Recorrido = $request->input('Tipo_De_Recorrido');
            $actividad->Observaciones = $request->input('Observaciones');
            $actividad->save();
            
            if ($request->hasFile('Evidencias')) {
                $files = $request->file('Evidencias');

                foreach($files as $file) {
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $archivo = date('His').$filename;
                    $destinationPath = public_path('evidencias');
                    $file->move($destinationPath, $archivo);

                    $evidencia = new ActividadEvidencias;
                    $evidencia->Id_Actividad = $actividad['Id_Actividad'];
                    $evidencia->Archivo = $archivo;
                    $evidencia->save();
                }
			}
			
			if ($request->hasFile('Registros')) {
                $files = $request->file('Registros');

                foreach($files as $file) {
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $archivo = date('His').$filename;
                    $destinationPath = public_path('registros');
                    $file->move($destinationPath, $archivo);

                    $registro = new ActividadRegistros;
                    $registro->Id_Actividad = $actividad['Id_Actividad'];
                    $registro->Archivo = $archivo;
                    $registro->save();
                }
            }

			return redirect('/actividades/formulario/'.$actividad['Id_Actividad'])->with(['status' => 'success']);
    }

    public function consultarUsuario(Request $request)
    {
        $persona = Usuario::with(['jornadas' => function($query){
                $query->where('Tipo', 'Ciclo expedición');
            }])->where('Documento_Usuario', $request->input('key'))->orderBy('Id_Usuario', 'desc')->first();

        return response()->json($persona);
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
