<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GuardarJornada extends Request
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
            'Id_Parque' => 'required',
            'Id_Promotor' => 'required',
            'Id_Localidad' => 'required',
            'Tipo' => 'required',
            'Clima' => 'required',
            'Nombre_Encargado' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'Fecha.required' => 'El campo fecha es requerido',
            'Id_Parque.required' => 'El campo lugar es requerido',
            'Id_Promotor.required' => 'Inicia sesión nuevamente y vuelve a intentar',
            'Id_Localidad.required' => 'El campo parque es requerido',
            'Tipo.required' => 'El campo tipo es requerido',
            'Clima.required' => 'El campo clima es requerido',
            'Nombre_Encargado.required' => 'El campo encargado es requerido'
        ];
    }
}
