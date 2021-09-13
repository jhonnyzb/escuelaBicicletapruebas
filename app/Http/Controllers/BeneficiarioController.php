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
use App\Modulos\Escuela\Beneficiario;
use App\Modulos\Escuela\Asistencia;
use Idrd\Usuarios\Repo\Documento;
use Idrd\Usuarios\Repo\Discapacidad;
use Idrd\Usuarios\Repo\GrupoSocial;
use Idrd\Usuarios\Repo\Genero;
use Idrd\Usuarios\Repo\Pais;
use Idrd\Usuarios\Repo\Etnia;
use Idrd\Parques\Repo\Localidad;
use App\Http\Requests\GuardarActividad;
use App\Http\Requests\GuardarBeneficiario;
use App\Http\Requests\GuardarClases;
use Mail;

class BeneficiarioController extends Controller
{
    private $niveles = [
        0 => ' A - No sabe montar bicicleta',
        1 => ' B - Pedalea con ruedas de entrenamiento',
        2 => ' C - Camina con la bicicleta',
        3 => ' D - Se impulsa y mantiene el equilibrio por instantes',
        4 => ' E - Se impulsa y mantiene el equilibrio',
        5 => ' F - Pedalea con apoyo',
        6 => ' G - Pedalea y mantiene el equilibrio por instantes',
        7 => ' H - Maneja',
        8 => ' I - Maneja y adquiere otras habilidades sobre la bicicleta'
    ];

    public function __construct()
	{
        if (isset($_SESSION['Usuario']))
        {
			$this->usuario = $_SESSION['Usuario'];
        
		    $this->promotor = Promotor::with('persona')
									->where('Id_Persona', $this->usuario[0])
                                    ->first();
        }
    }
    
    public function reservar(){
        $datos = [
	        'status' => session('status')
        ];

		return view('idrd.beneficiarios.reserva', $datos);
    }
    
    public function inscripcion() {

        $datos = [
            'documentos' => Documento::all(),
            'grupos' => GrupoSocial::all(),
            'discapacidades' => Discapacidad::all(),
            'etnias' => Etnia::all(),
            'localidades' => Localidad::where('Localidad','<>','distrital')
                                ->where('Localidad','<>','otro municipio o ciudad')
                                ->get(),
	        'status' => session('status')
        ];
		return view('idrd.beneficiarios.inscripcion', $datos);
    }

    public function consultar_beneficiario(Request $request){
        $usuario = Beneficiario::where('Documento', $request->documento)->first();
        
        return response()->json($usuario != "" ? 1 : 0 );

    }

    public function inscripcion_beneficiarios(GuardarBeneficiario $request){
        
        $beneficiario = new Beneficiario();
        $beneficiario->Nombre = strtoupper($request->Nombre ? $request->Nombre : '');
        $beneficiario->Id_Tipo_Documento = $request->Id_Tipo_Documento ? $request->Id_Tipo_Documento : '';
        $beneficiario->Id_Genero = $request->Id_Genero ? $request->Id_Genero : '';
        $beneficiario->Id_Grupo_Poblacional = $request->Genero_Poblacional ? $request->Genero_Poblacional : '';
        $beneficiario->Id_Discapacidad = $request->Discapacidad ? $request->Discapacidad : null;
        $beneficiario->Id_Localidad = $request->Id_Localidad ? $request->Id_Localidad : null;
        $beneficiario->Id_Upz = $request->Id_Upz ? $request->Id_Upz : null;
        $beneficiario->Id_Barrio = $request->Id_Barrio ? $request->Id_Barrio : null;
        $beneficiario->Municipio = $request->Municipio ? $request->Municipio : null;
        $beneficiario->Estrato = $request->Estrato ? $request->Estrato : null;
        $beneficiario->Documento = $request->Documento ? $request->Documento : '';
        $beneficiario->Correo = strtolower($request->Correo ? $request->Correo : '');
        $beneficiario->Telefono = $request->Telefono ? $request->Telefono : '';
        $beneficiario->Fecha_Nacimiento = $request->Fecha_Nacimiento ? $request->Fecha_Nacimiento : '';
        $beneficiario->Nombre_Acudiente = strtoupper($request->Nombre_Acudiente ? $request->Nombre_Acudiente : '');
        $beneficiario->Id_Tipo_Documento_Acudiente = $request->Tipo_Documento_Acudiente ? $request->Tipo_Documento_Acudiente : '';
        $beneficiario->save();

        return redirect('/reservar_clase/'.$beneficiario->Documento)->with('status', 'Usuario registrado satisfactoriamente');


    }

    public function reservar_clase($documento){

        $elementos = Escenario::with('jornadas', 'localidad')->where('Habilitado', '1')->get();
        $beneficiario = Beneficiario::where('Documento', $documento)->first();

		$datos = [
            'beneficiario' => $beneficiario,
            'elementos' => $elementos,
	        'status' => session('status')
		];

        return view('idrd.beneficiarios.reservar_clase', $datos);
    }

    public function consultar_disponibilidad(Request $request){

        $asistencias = Asistencia::where('Id_Escenario', $request->input('id_escenario'))
                            ->where('Id_Promotor', $request->input('id_promotor'))
                            ->where('Fecha', $request->input('fecha'))
                            ->get();

        $asistencia = Asistencia::where('Id_Escenario', $request->input('id_escenario'))
                            ->where('Id_Beneficiario', $request->input('id_beneficiario'))
                            ->where('Fecha', $request->input('fecha'))
                            ->get();

        $escenario = Escenario::find($request->input('id_escenario'));

        if($asistencia->count() == 0)
            $status = 100;
        else
            $status = 200;
        
        $hora_actual = (date('H') * 1) + 2;

        $inicio = $escenario['Hora_Inicio'] ? $escenario['Hora_Inicio'] : 8;
        $fin = $escenario['Hora_Fin'] ? $escenario['Hora_Fin'] + 1 : 15;

        if(date('Y-m-d') == $request->input('fecha'))
        {
            $inicio = $hora_actual;
            $fin = $inicio >= $fin ? -1 : $fin;
        } 
        
        $horas = [];

        if($fin != -1) {
            for($i = $inicio; $i < $fin; $i++)
            {
                $horas[$i] = 0;
            }
        }

        if(count($horas) > 0)
        {
            foreach ($asistencias->groupBy('Hora')->toArray() as $hora => $a) {
                if(array_key_exists($hora, $horas)) $horas[$hora]++;
            }
        }

        return response()->json([
            'status' => $status,
            'horas' => $horas
        ]);
    }

    public function guardar_clases(GuardarClases $request){
        //borrar si tiene una clase de ese dia
        $asistencia = Asistencia::where('Id_Escenario', $request->input('escenario'))
                            ->where('Id_Beneficiario', $request->input('id_beneficiario'))
                            ->where('Fecha', $request->input('fecha'))
                            ->first();

        $beneficiario = Beneficiario::find($request->input('id_beneficiario'));

        $escenario = Escenario::find($request->escenario);

        if (!$asistencia)
            $asistencia = new Asistencia();

        $asistencia->Id_Beneficiario = $request->id_beneficiario;
        $asistencia->Id_Promotor = $request->promotores;
        $asistencia->Id_Escenario = $request->escenario;
        $asistencia->Fecha = $request->fecha;
        $asistencia->Hora = $request->hora;
        $asistencia->save();

        $datos = [
            'titulo' => 'Inscripción exitosa',
            'destinatario' => $beneficiario->Nombre,
            'documento' => $beneficiario->Documento,
            'acudiente' => $beneficiario->Nombre_Acudiente,
            'dia' => $request->fecha, 
            'hora' => $request->hora,
            'parque' => $escenario->Nombre,
            'pie' => 'IDRD '.date('Y')
        ];

        Mail::send('email.notificacion', $datos, function($m) use ($beneficiario)
        {
            $m->from('mails@idrd.gov.co', 'Escuela de la bicicleta');
            $m->to($beneficiario->Correo, $beneficiario->Nombre)->subject('Notificación clase');
        });

        return view('idrd.beneficiarios.mensaje_reserva', $datos);
    }

    public function listar_clases(){
        //dd(session('fecha'));
        if(session('fecha'))
        {
            $clases = Asistencia::with('beneficiario')->where('Id_Promotor', $this->promotor['Id_Promotor'])
                            ->where('Fecha', session('fecha'))
                            ->get();
        } else {
            $clases = null;
        }

        $datos = [
            'niveles' => $this->niveles,
            'clases' => $clases ? $clases->groupBy('Hora') : null,
	        'status' => session('status')
        ];

		return view('idrd.beneficiarios.clases', $datos);
    }

    public function consultar_clases(Request $request)
    {
        
        $clases = Asistencia::with('beneficiario.asistencias_revisadas')->where('Id_Promotor', $this->promotor['Id_Promotor'])
                            ->where('Fecha', $request->input('fecha', session('fecha')))
                            ->get();
        
        $datos = [
            'niveles' => $this->niveles,
            'clases' => $clases->groupBy('Hora'),
            'status' => session('status')
        ];

        return view('idrd.beneficiarios.clases', $datos);
    }

    public function guardar_asistencia(Request $request) 
    {
        $asistencias = $request->input('id');
        foreach($asistencias as $id)
        {
            $asistencia = Asistencia::find($id);
            $asistencia['Nivel_Destreza'] = $request->input($id.'_nivel', null);
            $asistencia['Asistio'] = $request->input($id.'_asistencia', null);
            $asistencia->save();
        }

        return redirect('asistencias')
            ->with('status', 'success')
            ->with('fecha', $asistencia->Fecha);
    }

    public function perfil(Request $request, $documento = '')
    {
        if($documento != '')
        {
            $beneficiario = Beneficiario::where('Documento', $documento)->first();
            $asistencias = Asistencia::with('promotor.persona', 'escenario')->where('Id_Beneficiario', $beneficiario ? $beneficiario->Id_Beneficiario : '0')->orderBy('Fecha', 'asc')->get();
            //dd($asistencias);
        } else {
            $beneficiario = null;
            $asistencias = null;
        }

        $datos = [
            'beneficiario' => $beneficiario,
            'asistencias' => $asistencias
        ];

        return view('idrd.beneficiarios.perfil', $datos);
    }

    public function cancelar_clase($cedula){
        
        $usuario = Beneficiario::where('Documento', $cedula)->first();

        $hora = date('H') * 1;
        $dia = date('Y-m-d');

        if(count($usuario) > 0 ) {
            $clases = Asistencia::with('beneficiario','promotor','escenario')->where('Id_Beneficiario', $usuario->Id_Beneficiario)
                            ->whereNull('Asistio')
                            ->where(function($q) use ($dia) {
                                $q->where('Fecha', '>', $dia);
                            })
                            ->orWhere(function($q) use ($dia, $hora) {
                                $q->where('Fecha', $dia)
                                    ->where('Hora', '>', $hora + 3);
                            })
                            ->OrderBy('Fecha')
                            ->get();
        }else{
            $clases = null;
        }

    
        $datos = [
            'clases' => $clases ? $clases : null,
	        'status' => session('status')
        ];

        //dd($datos);

		return view('idrd.beneficiarios.cancelar_clase', $datos);
    }

    public function eliminar_clase($asistencia) {
        $clase = Asistencia::find($asistencia);
        $documento = Beneficiario::where('Id_Beneficiario', $clase->Id_Beneficiario)->first();

        $clase->delete();
        return redirect('/cancelar_clase/'.$documento->Documento)->with('status', 'Datos actualizados satisfactorimente');
    }

}