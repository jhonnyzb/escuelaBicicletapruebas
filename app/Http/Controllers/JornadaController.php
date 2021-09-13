<?php

namespace App\Http\Controllers;

use App\Modulos\Escuela\Usuario;
use Illuminate\Http\Request;
use App\Modulos\Escuela\Promotor;
use App\Modulos\Escuela\Jornada;
use App\Modulos\Escuela\Escenario;
use Idrd\Usuarios\Repo\Documento;
use Idrd\Usuarios\Repo\Pais;
use Idrd\Usuarios\Repo\Etnia;
use Idrd\Parques\Repo\Localidad;
use App\Http\Requests\GuardarJornada;

class JornadaController extends Controller
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
			$qb = Jornada::with('usuarios', 'escenario')
							->where('Id_Promotor', $this->promotor['Id_Promotor']);

			$qb = $this->aplicarFiltro($qb, $request);

			$elementos = $qb->whereNull('deleted_at')
							->orderBy('Id_Jornada', 'DESC')
							->get();
		}



		$lista = [
	        'elementos' => $elementos,
			'parques' => Escenario::all(),
	        'status' => session('status')
		];

		$datos = [
			'titulo' => 'Jornadas promotor',
			'seccion' => 'Buscar jornadas',
			'lista'	=> view('idrd.jornadas.lista', $lista)
		];

		return view('list', $datos);
    }

    public function formulario(Request $request, $id_jornada = 0)
    {
    	$jornada = null;

    	if ($id_jornada)
    		$jornada = Jornada::with('usuarios.jornadas', 'escenario')->find($id_jornada);

    	$formulario = [
			'jornada' => $jornada,
			'promotor' => $this->promotor,
			'parques' => Escenario::all(),
			'localidades' => Localidad::all(),
			'documentos' => Documento::all(),
	        'paises' => Pais::all(),
	        'etnias' => Etnia::all(),
	        'localidades' => Localidad::all(),
	        'status' => session('status')
		];

		//dd($this->usuario);

		$datos = [
			'titulo' => 'Crear ó editar jornadas',
			'seccion' => 'Crear jornadas',
			'formulario' => view('idrd.jornadas.formulario', $formulario)
		];

		return view('form', $datos);
    }

		public function eliminar(Request $request, $id_jornada) {
			$jornada = Jornada::find($id_jornada);
			$jornada->delete();

			return redirect('/jornadas');
		}

    public function procesar(GuardarJornada $request)
    {
    	if($request->input('Id_Jornada') == '0')
    		$jornada = new Jornada;
    	else
    		$jornada = Jornada::find($request->input('Id_Jornada'));

  		$jornada->Id_Promotor = $request->input('Id_Promotor');
		$jornada->Id_Parque = $request->input('Id_Parque');
		$jornada->Id_Localidad = $request->input('Id_Localidad');
		$jornada->Tipo = $request->input('Tipo');
		$jornada->Fecha = $request->input('Fecha');
		$jornada->Clima = $request->input('Clima');
		$jornada->Nombre_Encargado = $request->input('Nombre_Encargado');
		$jornada->Observaciones_Generales = $request->input('Observaciones_Generales');
		$jornada->save();

		$usuarios = json_decode($request->input('usuarios'), true);
		$jornada->usuarios()->forceDelete();

		foreach ($usuarios as &$usuario)
		{
			unset($usuario['Id_Usuario']);
			$jornada->usuarios()->create($usuario);
		}

		return redirect('/jornadas/formulario/'.$jornada['Id_Jornada'])->with(['status' => 'success']);
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
		if($request->input('parque') && $request->input('parque') != 'Todos')
		{
			$qb->where('Id_Parque', $request->input('parque'));
		}

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
