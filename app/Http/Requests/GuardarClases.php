<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Modulos\Escuela\Asistencia;
use Carbon\Carbon;

class GuardarClases extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $asistencia = Asistencia::where('Id_Beneficiario', $this->id_beneficiario)
                            ->where('Fecha', $this->fecha)
                            ->where('Hora', $this->hora)
                            ->where('Id_Escenario', '<>', $this->Id_Escenario)
                            ->get();
        //dd($asistencia);
        $rules = [
            'escenario' => 'required',
            'promotores' => 'required',
            'fecha' => 'required|date',
            'hora' => 'required',
        ];

        if($asistencia->count() > 0)
        {
            $rules['cruze_horarios'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'escenario.required' => 'El campo escenario es requerido',
            'promotores.required' => 'El campo promotor es requerido',
            'fecha.required' => 'El campo fecha es requerido',
            'hora.required' => 'El campo hora es requerido',
            'cruze_horarios.required' => 'Ya tiene una clase asignada en el mismo horario en otro escenario por favor seleccione otra hora'
        ];
    }
}
