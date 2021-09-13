<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GenerarCertificado extends Request
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
            'documento' => 'required|exists:Beneficiarios,Documento'
        ];
    }

    public function messages()
    {
        return [
            'documento.required' => 'El campo documento es requerido',
            'documento.exists' => 'No se han registrado usuarios con ese número de documento.'
        ];
    }
}
