<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GuardarActividad extends Request
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
        return [
            'Fecha' => 'required',
            'Nombre_Del_Evento' => 'required',
            'Tipo' => 'required',
            'Mecanicos' => 'required',
            'Objetivo' => 'required',
            'Empresa' => 'required',
            'Encargado' => 'required',
            'Telefono' => 'required',
            'Punto_De_Encuentro' => 'required',
            'Hora_Inicio' => 'required',
            'Hora_Fin' => 'required',
            'Id_Promotor' => 'required',
            'Participantes_Femenino' => 'required',
            'Participantes_Masculino' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'Fecha.required' => 'El campo fecha es requerido',
            'Id_Promotor.required' => 'Inicia sesión nuevamente y vuelve a intentar',
            'Nombre_Del_Evento.required' => 'El campo nombre del evento es requerido',
            'Tipo.required' => 'El campo tipo del evento es requerido',
            'Mecanicos.required' => 'El campo guías y/o mecánicos encargados es requerido',
            'Objetivo.required' => 'El campo objetivo de la actividad es requerido',
            'Empresa.required' => 'El campo empresa es requerido',
            'Encargado.required' => 'El campo persona encargada es requerido',
            'Telefono.required' => 'El campo telefono es requerido',
            'Punto_De_Encuentro.required' => 'El campo punto de encuentro es requerido',
            'Hora_Inicio.required' => 'El campo hora inicio es requerido',
            'Hora_Fin.required' => 'El campo hora fin es requerido',
            'Participantes_Femenino.required' => 'El campo hombres es requerido',
            'Participantes_Masculino.required' => 'El campo mujeres es requerido'
        ];
    }
}
