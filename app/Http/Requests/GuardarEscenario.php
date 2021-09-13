<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GuardarEscenario extends Request
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
            'Nombre' => 'required',
            'Id_Localidad' => 'required',
            'Hora_Inicio' => 'required',
            'Hora_Fin' => 'required',
            'Habilitado' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'Nombre.required' => 'El campo nombre es requerido',
            'Id_Localidad.required' => 'El campo localidad es requerido',
            'Hora_Inicio.required' => 'El campo hora inicio es requerido',
            'Hora_Fin.required' => 'El campo hora fin es requerido',
            'Habilitado.required' => 'El campo habilitado es requerido'
        ];
    }
}
