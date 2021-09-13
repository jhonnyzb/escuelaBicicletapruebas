<?php

namespace App\Http\Controllers;

use App\Modulos\Escuela\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests\GenerarCertificado;
use App\Modulos\Escuela\Beneficiario;
use App\Modulos\Escuela\Asistencia;
use PDF;

class CertificadoController extends Controller
{
    public function index()
    {
        $data = [
            'titulo' => 'Certificados',
            'seccion' => 'Certificados',
            'status' => session('status')
        ];

        return view('idrd.certificados.index', $data);
    }

    public function generar(GenerarCertificado $request)
    {
        $beneficiario = Beneficiario::where('Documento', $request->input('documento'))->first();

        $asistencia = Asistencia::where('Id_Beneficiario', $beneficiario->Id_Beneficiario)
                        ->where('Nivel_Destreza', '8')
                        ->first();

        if ($asistencia) {
            $pdf = PDF::loadView('idrd.certificados.diploma', ['nombre' => $beneficiario->Nombre]);
            $pdf->setPaper('a4', 'landscape')->setWarnings(false);

            return $pdf->download('diploma.pdf');
        } else {
            return redirect('/certificado')->with('status', 'sin terminar');
        }

    }
}
