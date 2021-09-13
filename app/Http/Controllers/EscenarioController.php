<?php 

namespace App\Http\Controllers;

use App\Modulos\Escuela\Escenario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarEscenario;
use App\Modulos\Escuela\Promotor;
use Idrd\Parques\Repo\Localidad;
use App\Modulos\Escuela\Asistencia;
use Mail;

class EscenarioController extends Controller {
	public function __construct() {

	}

	public function index() {
		$elementos = Escenario::with('jornadas', 'localidad')->get();
		$datos = [
	        'elementos' => $elementos,
	        'status' => session('status')
		];

		return view('idrd.escenarios.lista', $datos);
	}

	public function crear()	{
		return $this->cargarFormulario(null);
	}

	public function editar(Request $request, $id) {
		$escenaro = Escenario::with('jornadas')->find($id);

		return $this->cargarFormulario($escenaro);
	}

	public function eliminar(Request $request, $id) {
		$escenario = Escenario::with('jornadas')->find($id);
		$escenario->delete();

		return redirect('/escenarios')->with(['status' => 'success']);
	}

	private function cargarFormulario($escenario) {
		$datos = [
			'escenario' => $escenario,
			'localidades' => Localidad::all(),
	        'status' => session('status')
		];

		return view('idrd.escenarios.formulario', $datos);
	}

	public function procesar(GuardarEscenario $request) {
		if ($request->input('Id_Escenario') != '0') 
			$escenario = Escenario::find($request->input('Id_Escenario'));
		else
			$escenario = new Escenario;

		$escenario['Nombre'] = $request->input('Nombre');
		$escenario['Id_Localidad'] = $request->input('Id_Localidad');
		$escenario['Hora_Inicio'] = $request->input('Hora_Inicio');
		$escenario['Hora_Fin'] = $request->input('Hora_Fin');
		$escenario['Habilitado'] = $request->input('Habilitado');
		
		$escenario->save();

		return redirect('/escenarios/'.$escenario['Id_Escenario'].'/editar')->with(['status' => 'success']);
	}

	public function asignar(){
		$elementos = Escenario::with('jornadas', 'localidad')->get();
		$promotores = Promotor::with('persona')->get();

		$datos = [
			'elementos' => $elementos,
			'promotores' => $promotores,
	        'status' => session('status')
		];

		return view('idrd.escenarios.asignacion', $datos);
	}

	public function guardar_asignacion(Request $request){

        $escenario = Escenario::find($request->escenario);
       /*  $escenarios = [];

        foreach ($request['escenario'] as $value) {

            $escenarios = Escenario::where('Id_Escenario',$value)->get();
            foreach ($escenarios as $escenario) {
                $escenarios[] = $escenario->Id_Escenario;
            }
            
		} */
		
		$promotores = is_array($request['promotor']) ? $request['promotor'] : [$request['promotor']];
        
        $escenario->promotores()->sync($promotores);

        return redirect('asignacion')->with(['status' => 'success']);
	}

	public function cancelar(Request $request){
		$asistencias = Asistencia::with('beneficiario')->where('Id_Escenario', $request->input('Id_Escenario'))
							->where('Fecha', $request->input('Fecha', '1900-10-10'))
							->get();
		
		foreach($asistencias as $asistencia)
		{
			$beneficiario = $asistencia->beneficiario;
			$datos = [
				'titulo' => 'Clase cancelada',
				'destinatario' => $beneficiario->Nombre,
				'dia' => $asistencia->Fecha,
				'pie' => 'IDRD '.date('Y')
			];
			Mail::send('email.clasecancelada', $datos, function($m) use ($beneficiario)
			{
				$m->from('mails@idrd.gov.co', 'Escuela de la bicicleta');
				$m->to($beneficiario->Correo, $beneficiario->Nombre)->subject('Notificación clase');
			});
			$asistencia->delete();
		}

		return redirect('/escenarios/'.$request->input('Id_Escenario').'/editar')->with(['status' => 'success']);
	}
	
	public function consultar_escenarios(Request $request){
		$promotor = Promotor::with('escenarios')->where('Id_Promotor',$request->id_promotor)->first();
        $escenarios = $promotor->escenarios->pluck('Id_Escenario')->unique()->toArray();
        return response()->json(array_values($escenarios));
	}

	public function consultar_promotor(Request $request){
		$escenario = Escenario::with('promotores.persona')->where('Id_Escenario',$request->id_escenario)->first();
		return response()->json($escenario->promotores);
		
	}

	public function consultar_promotores(Request $request){
		$escenario = Escenario::with('promotores.persona')->where('Id_Escenario',$request->id_escenario)->first();
		
		$promotores = [];
		if(count($escenario->promotores) > 0){
			$promotores = $escenario->promotores->pluck('Id_Promotor')->unique()->toArray();
		}

		return response()->json($promotores);
		
	}
	
}